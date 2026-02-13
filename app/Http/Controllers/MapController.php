<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMapsService;

class MapController extends Controller
{
    protected $googleMaps;

    public function __construct(GoogleMapsService $googleMaps)
    {
        $this->middleware('auth');
        $this->googleMaps = $googleMaps;
    }

    public function index()
    {
        return view('map.index');
    }

    /**
     * Get all active drivers with their current locations
     */
    public function getActiveDrivers()
    {
        $database = app('firebase.firestore')->database();
        $driversRef = $database->collection('users')
            ->where('type', '==', 'driver')
            ->where('isActive', '==', true)
            ->where('isApproved', '==', true);

        $activeDrivers = [];
        
        foreach ($driversRef->documents() as $driverDoc) {
            if ($driverDoc->exists()) {
                $driver = $driverDoc->data();
                
                if (isset($driver['location']) && isset($driver['location']['latitude']) && isset($driver['location']['longitude'])) {
                    $activeDrivers[] = [
                        'id' => $driverDoc->id(),
                        'name' => $driver['firstName'] . ' ' . $driver['lastName'],
                        'email' => $driver['email'],
                        'phone' => $driver['phoneNumber'],
                        'latitude' => $driver['location']['latitude'],
                        'longitude' => $driver['location']['longitude'],
                        'rating' => $driver['rating'] ?? 0,
                        'totalDeliveries' => $driver['totalDeliveries'] ?? 0,
                        'currentOrderId' => $driver['currentOrderId'] ?? null
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'drivers' => $activeDrivers
        ]);
    }

    /**
     * Get order details for tracking
     */
    public function getOrderInfo(Request $request)
    {
        $orderId = $request->input('order_id');
        
        $database = app('firebase.firestore')->database();
        $orderRef = $database->collection('orders')->document($orderId);
        $order = $orderRef->snapshot()->data();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Get restaurant and customer details
        $restaurantRef = $database->collection('vendors')->document($order['vendorId']);
        $restaurant = $restaurantRef->snapshot()->data();

        $customerRef = $database->collection('users')->document($order['userId']);
        $customer = $customerRef->snapshot()->data();

        $driver = null;
        if (isset($order['driverId'])) {
            $driverRef = $database->collection('users')->document($order['driverId']);
            $driver = $driverRef->snapshot()->data();
            $driver['id'] = $order['driverId'];
        }

        $orderDetails = [
            'id' => $orderId,
            'orderNumber' => $order['orderNumber'],
            'status' => $order['orderStatus'],
            'restaurant' => [
                'id' => $order['vendorId'],
                'name' => $restaurant['name'],
                'address' => $restaurant['address'],
                'latitude' => $restaurant['location']['latitude'],
                'longitude' => $restaurant['location']['longitude']
            ],
            'customer' => [
                'id' => $order['userId'],
                'name' => $order['userName'],
                'phone' => $order['userPhone'],
                'address' => $order['deliveryAddress'],
                'latitude' => $order['deliveryLocation']['latitude'],
                'longitude' => $order['deliveryLocation']['longitude']
            ],
            'driver' => $driver,
            'items' => $order['items'],
            'total' => $order['total'],
            'createdAt' => $order['createdAt']
        ];

        // Calculate route from restaurant to customer
        if (isset($order['deliveryLocation']) && $restaurant) {
            $route = $this->googleMaps->getDirections(
                "{$restaurant['location']['latitude']},{$restaurant['location']['longitude']}",
                "{$order['deliveryLocation']['latitude']},{$order['deliveryLocation']['longitude']}"
            );
            
            if (isset($route['routes'][0])) {
                $orderDetails['route'] = $route['routes'][0];
            }
        }

        return response()->json([
            'success' => true,
            'order' => $orderDetails
        ]);
    }

    /**
     * Get real-time driver location for tracking
     */
    public function getDriverLocation($driverId)
    {
        $database = app('firebase.firestore')->database();
        $driverRef = $database->collection('users')->document($driverId);
        $driver = $driverRef->snapshot()->data();

        if (!$driver || !isset($driver['location'])) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found or location not available'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'location' => [
                'latitude' => $driver['location']['latitude'],
                'longitude' => $driver['location']['longitude'],
                'timestamp' => $driver['location']['timestamp'] ?? null
            ]
        ]);
    }
}