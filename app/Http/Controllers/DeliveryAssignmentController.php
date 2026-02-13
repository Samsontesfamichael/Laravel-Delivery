<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMapsService;
use Illuminate\Support\Facades\DB;

class DeliveryAssignmentController extends Controller
{
    protected $googleMaps;

    public function __construct(GoogleMapsService $googleMaps)
    {
        $this->middleware('auth');
        $this->googleMaps = $googleMaps;
    }

    /**
     * Get nearest available drivers
     */
    public function getNearestDrivers(Request $request)
    {
        $restaurantLat = $request->input('restaurant_lat');
        $restaurantLng = $request->input('restaurant_lng');
        $radius = $request->input('radius', 5000); // Default 5km

        // Get available drivers from Firestore
        $database = app('firebase.firestore')->database();
        $driversRef = $database->collection('users')
            ->where('type', '==', 'driver')
            ->where('isActive', '==', true)
            ->where('isApproved', '==', true);

        $availableDrivers = [];
        
        foreach ($driversRef->documents() as $driverDoc) {
            if ($driverDoc->exists()) {
                $driver = $driverDoc->data();
                
                // Check if driver has location
                if (isset($driver['location']) && isset($driver['location']['latitude']) && isset($driver['location']['longitude'])) {
                    $driverLat = $driver['location']['latitude'];
                    $driverLng = $driver['location']['longitude'];
                    
                    // Calculate distance using Google Maps API
                    $distance = $this->googleMaps->getDistance(
                        "$restaurantLat,$restaurantLng",
                        "$driverLat,$driverLng"
                    );
                    
                    if ($distance && $distance['distance']['value'] <= $radius) {
                        $availableDrivers[] = [
                            'id' => $driverDoc->id(),
                            'name' => $driver['firstName'] . ' ' . $driver['lastName'],
                            'email' => $driver['email'],
                            'phone' => $driver['phoneNumber'],
                            'latitude' => $driverLat,
                            'longitude' => $driverLng,
                            'distance' => $distance['distance'],
                            'duration' => $distance['duration'],
                            'rating' => $driver['rating'] ?? 0,
                            'totalDeliveries' => $driver['totalDeliveries'] ?? 0
                        ];
                    }
                }
            }
        }

        // Sort drivers by distance
        usort($availableDrivers, function($a, $b) {
            return $a['distance']['value'] - $b['distance']['value'];
        });

        return response()->json([
            'success' => true,
            'drivers' => $availableDrivers
        ]);
    }

    /**
     * Auto-assign order to nearest driver
     */
    public function autoAssignOrder(Request $request)
    {
        $orderId = $request->input('order_id');
        
        // Get order details from Firestore
        $database = app('firebase.firestore')->database();
        $orderRef = $database->collection('orders')->document($orderId);
        $order = $orderRef->snapshot()->data();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Get restaurant location
        $restaurantRef = $database->collection('vendors')->document($order['vendorId']);
        $restaurant = $restaurantRef->snapshot()->data();

        if (!$restaurant || !isset($restaurant['location'])) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant location not found'
            ], 404);
        }

        $restaurantLat = $restaurant['location']['latitude'];
        $restaurantLng = $restaurant['location']['longitude'];

        // Get nearest drivers
        $nearestDrivers = $this->getNearestDrivers($request->merge([
            'restaurant_lat' => $restaurantLat,
            'restaurant_lng' => $restaurantLng,
            'radius' => 5000
        ]))->original['drivers'];

        if (empty($nearestDrivers)) {
            return response()->json([
                'success' => false,
                'message' => 'No available drivers nearby'
            ], 404);
        }

        // Assign to nearest driver
        $assignedDriver = $nearestDrivers[0];
        
        // Update order with driver information
        $orderRef->update([
            'driverId' => $assignedDriver['id'],
            'driverName' => $assignedDriver['name'],
            'driverPhone' => $assignedDriver['phone'],
            'orderStatus' => 'Driver Assigned'
        ]);

        // Add notification for driver
        $notificationRef = $database->collection('notifications')->document();
        $notificationRef->set([
            'userId' => $assignedDriver['id'],
            'title' => 'New Order Assigned',
            'message' => "You have been assigned a new order #$orderId",
            'type' => 'order_assignment',
            'orderId' => $orderId,
            'isRead' => false,
            'createdAt' => app('firebase.firestore')->database()->timestamp()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order assigned successfully',
            'driver' => $assignedDriver
        ]);
    }

    /**
     * Get driver assignment history
     */
    public function getAssignmentHistory($driverId)
    {
        $database = app('firebase.firestore')->database();
        $assignmentsRef = $database->collection('orders')
            ->where('driverId', '==', $driverId)
            ->orderBy('createdAt', 'desc');

        $assignments = [];
        
        foreach ($assignmentsRef->documents() as $doc) {
            if ($doc->exists()) {
                $order = $doc->data();
                $assignments[] = [
                    'id' => $doc->id(),
                    'orderNumber' => $order['orderNumber'],
                    'customerName' => $order['userName'],
                    'customerPhone' => $order['userPhone'],
                    'deliveryAddress' => $order['deliveryAddress'],
                    'status' => $order['orderStatus'],
                    'createdAt' => $order['createdAt'],
                    'updatedAt' => $order['updatedAt']
                ];
            }
        }

        return response()->json([
            'success' => true,
            'assignments' => $assignments
        ]);
    }

    /**
     * Get order assignment analytics
     */
    public function getAssignmentAnalytics()
    {
        $database = app('firebase.firestore')->database();
        
        // Get total assignments by day
        $assignmentsRef = $database->collection('orders')
            ->where('orderStatus', '==', 'Driver Assigned')
            ->orderBy('createdAt', 'desc');

        $dailyAssignments = [];
        
        foreach ($assignmentsRef->documents() as $doc) {
            if ($doc->exists()) {
                $order = $doc->data();
                $date = $order['createdAt']->format('Y-m-d');
                $dailyAssignments[$date] = ($dailyAssignments[$date] ?? 0) + 1;
            }
        }

        return response()->json([
            'success' => true,
            'dailyAssignments' => $dailyAssignments,
            'totalAssignments' => array_sum($dailyAssignments)
        ]);
    }
}
