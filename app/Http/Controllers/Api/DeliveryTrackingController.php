<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DeliveryTrackingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DeliveryTrackingController extends Controller
{
    protected $trackingService;

    public function __construct(DeliveryTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Get driver location
     * GET /api/delivery/driver/{driverId}/location
     */
    public function getDriverLocation($driverId): JsonResponse
    {
        $location = $this->trackingService->getDriverLocation($driverId);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Driver location not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $location,
        ]);
    }

    /**
     * Update driver location
     * POST /api/delivery/driver/location
     */
    public function updateLocation(Request $request): JsonResponse
    {
        $request->validate([
            'driver_id' => 'required|integer',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'heading' => 'nullable|numeric|between:0,360',
        ]);

        $location = $this->trackingService->updateDriverLocation(
            $request->driver_id,
            $request->latitude,
            $request->longitude,
            $request->heading
        );

        return response()->json([
            'success' => true,
            'data' => $location,
        ]);
    }

    /**
     * Calculate delivery ETA
     * POST /api/delivery/eta
     */
    public function calculateETA(Request $request): JsonResponse
    {
        $request->validate([
            'restaurant_lat' => 'required|numeric',
            'restaurant_lng' => 'required|numeric',
            'customer_lat' => 'required|numeric',
            'customer_lng' => 'required|numeric',
        ]);

        $eta = $this->trackingService->calculateETA(
            $request->restaurant_lat,
            $request->restaurant_lng,
            $request->customer_lat,
            $request->customer_lng
        );

        if (!$eta) {
            return response()->json([
                'success' => false,
                'message' => 'Could not calculate ETA',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $eta,
        ]);
    }

    /**
     * Get optimized route
     * POST /api/delivery/route
     */
    public function getOptimizedRoute(Request $request): JsonResponse
    {
        $request->validate([
            'waypoints' => 'required|array|min:2',
            'waypoints.*.lat' => 'required|numeric',
            'waypoints.*.lng' => 'required|numeric',
        ]);

        $route = $this->trackingService->getOptimizedRoute($request->waypoints);

        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Could not calculate route',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $route,
        ]);
    }

    /**
     * Get address from coordinates (Reverse Geocoding)
     * GET /api/delivery/geocode?lat=...&lng=...
     */
    public function geocode(Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        $address = $this->trackingService->getAddressFromCoordinates(
            $request->lat,
            $request->lng
        );

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Could not find address',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $address,
        ]);
    }

    /**
     * Get coordinates from address
     * GET /api/delivery/geocode?address=...
     */
    public function geocodeAddress(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string',
        ]);

        $coordinates = $this->trackingService->getCoordinatesFromAddress(
            $request->address
        );

        if (!$coordinates) {
            return response()->json([
                'success' => false,
                'message' => 'Could not find coordinates',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $coordinates,
        ]);
    }

    /**
     * Check delivery zone
     * POST /api/delivery/zone
     */
    public function checkDeliveryZone(Request $request): JsonResponse
    {
        $request->validate([
            'customer_lat' => 'required|numeric',
            'customer_lng' => 'required|numeric',
            'restaurant_lat' => 'required|numeric',
            'restaurant_lng' => 'required|numeric',
        ]);

        $zone = $this->trackingService->getDeliveryZone(
            $request->customer_lat,
            $request->customer_lng,
            $request->restaurant_lat,
            $request->restaurant_lng
        );

        return response()->json([
            'success' => true,
            'data' => $zone,
        ]);
    }

    /**
     * Track order delivery
     * GET /api/delivery/order/{orderId}/track
     */
    public function trackOrder($orderId): JsonResponse
    {
        // This would fetch order, driver, and customer info from database
        // For demo, returning mock data
        
        $order = array(
            'id' => $orderId,
            'status' => 'out_for_delivery',
            'restaurant' => array(
                'name' => 'Sample Restaurant',
                'lat' => -1.2921,
                'lng' => 36.8219,
            ),
            'customer' => array(
                'name' => 'John Doe',
                'address' => '123 Main St',
                'lat' => -1.2950,
                'lng' => 36.8250,
            ),
            'driver' => array(
                'id' => 1,
                'name' => 'Driver Mike',
                'phone' => '+1234567890',
                'lat' => -1.2935,
                'lng' => 36.8230,
            ),
        );

        // Calculate ETA
        $eta = $this->trackingService->calculateETA(
            $order['driver']['lat'],
            $order['driver']['lng'],
            $order['customer']['lat'],
            $order['customer']['lng']
        );

        return response()->json([
            'success' => true,
            'data' => array(
                'order' => $order,
                'eta' => $eta,
                'driver_location' => array(
                    'lat' => $order['driver']['lat'],
                    'lng' => $order['driver']['lng'],
                ),
            ),
        ]);
    }

    /**
     * Get nearby available drivers
     * GET /api/delivery/nearby-drivers
     */
    public function getNearbyDrivers(Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:50',
        ]);

        $radius = $request->radius ?? 5;
        
        // This would query drivers within radius from database
        // For demo, returning mock data
        
        $drivers = array(
            array(
                'id' => 1,
                'name' => 'Driver John',
                'phone' => '+1234567890',
                'distance' => 1.2,
                'eta_minutes' => 5,
                'rating' => 4.8,
                'vehicle_type' => 'car',
            ),
            array(
                'id' => 2,
                'name' => 'Driver Sarah',
                'phone' => '+1234567891',
                'distance' => 2.0,
                'eta_minutes' => 8,
                'rating' => 4.9,
                'vehicle_type' => 'motorcycle',
            ),
        );

        return response()->json([
            'success' => true,
            'data' => $drivers,
        ]);
    }
}
