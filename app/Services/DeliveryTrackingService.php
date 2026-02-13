<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DeliveryTrackingService
{
    protected $apiKey;
    protected $apiBaseUrl = 'https://maps.googleapis.com/maps/api';

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
    }

    /**
     * Get current location of a driver
     */
    public function getDriverLocation($driverId)
    {
        // Get from cache (updated by driver app)
        $location = Cache::get('driver_location_' . $driverId);
        
        return $location ? json_decode($location, true) : null;
    }

    /**
     * Update driver location (called from driver app)
     */
    public function updateDriverLocation($driverId, $latitude, $longitude, $heading = null)
    {
        $locationData = array(
            'driver_id' => $driverId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'heading' => $heading,
            'timestamp' => now()->toIso8601String(),
        );
        
        // Store for 5 minutes
        Cache::put('driver_location_' . $driverId, json_encode($locationData), 300);
        
        // Store in database for history
        $this->saveLocationHistory($driverId, $latitude, $longitude);
        
        return $locationData;
    }

    /**
     * Calculate ETA from restaurant to customer
     */
    public function calculateETA($originLat, $originLng, $destLat, $destLng)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/distancematrix/json', array(
                'origins' => $originLat . ',' . $originLng,
                'destinations' => $destLat . ',' . $destLng,
                'key' => $this->apiKey,
                'mode' => 'driving',
                'traffic_model' => 'best_guess',
            ));

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK' && count($data['rows']) > 0) {
                    $element = $data['rows'][0]['elements'][0];
                    
                    if ($element['status'] === 'OK') {
                        return array(
                            'distance_text' => $element['distance']['text'],
                            'distance_value' => $element['distance']['value'], // meters
                            'duration_text' => $element['duration']['text'],
                            'duration_value' => $element['duration']['value'], // seconds
                            'duration_in_traffic_text' => isset($element['duration_in_traffic']['text']) 
                                ? $element['duration_in_traffic']['text'] : null,
                            'duration_in_traffic_value' => isset($element['duration_in_traffic']['value']) 
                                ? $element['duration_in_traffic']['value'] : null,
                        );
                    }
                }
            }
            
            return null;

        } catch (\Exception $e) {
            Log::error('ETA calculation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get optimized route for multiple stops
     */
    public function getOptimizedRoute($waypoints)
    {
        try {
            $waypointString = implode('|', array_map(function ($w) {
                return $w['lat'] . ',' . $w['lng'];
            }, $waypoints));

            $response = Http::get($this->apiBaseUrl . '/directions/json', array(
                'origin' => $waypoints[0]['lat'] . ',' . $waypoints[0]['lng'],
                'destination' => end($waypoints)['lat'] . ',' . end($waypoints)['lng'],
                'waypoints' => 'optimize:true|' . $waypointString,
                'key' => $this->apiKey,
                'mode' => 'driving',
            ));

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK') {
                    $route = $data['routes'][0];
                    
                    return array(
                        'waypoint_order' => $route['waypoint_order'],
                        'overview_polyline' => $route['overview_polyline']['points'],
                        'bounds' => $route['bounds'],
                        'legs' => array_map(function ($leg) {
                            return array(
                                'start_address' => $leg['start_address'],
                                'end_address' => $leg['end_address'],
                                'distance_text' => $leg['distance']['text'],
                                'duration_text' => $leg['duration']['text'],
                                'steps' => array_map(function ($step) {
                                    return array(
                                        'instruction' => $step['html_instructions'],
                                        'distance' => $step['distance']['text'],
                                        'duration' => $step['duration']['text'],
                                        'polyline' => $step['polyline']['points'],
                                    );
                                }, $leg['steps']),
                            );
                        }, $route['legs']),
                    );
                }
            }
            
            return null;

        } catch (\Exception $e) {
            Log::error('Route optimization error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get geocode address
     */
    public function getAddressFromCoordinates($lat, $lng)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/geocode/json', array(
                'latlng' => $lat . ',' . $lng,
                'key' => $this->apiKey,
            ));

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK' && count($data['results']) > 0) {
                    return array(
                        'formatted_address' => $data['results'][0]['formatted_address'],
                        'components' => $this->parseAddressComponents($data['results'][0]['address_components']),
                    );
                }
            }
            
            return null;

        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get coordinates from address
     */
    public function getCoordinatesFromAddress($address)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/geocode/json', array(
                'address' => $address,
                'key' => $this->apiKey,
            ));

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK' && count($data['results']) > 0) {
                    $location = $data['results'][0]['geometry']['location'];
                    
                    return array(
                        'latitude' => $location['lat'],
                        'longitude' => $location['lng'],
                        'formatted_address' => $data['results'][0]['formatted_address'],
                    );
                }
            }
            
            return null;

        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // km

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLng = deg2rad($lng2 - $lng1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($deltaLng / 2) * sin($deltaLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Check if driver is within delivery radius
     */
    public function isWithinDeliveryRadius($driverLat, $driverLng, $customerLat, $customerLng, $radiusKm = 5)
    {
        $distance = $this->calculateDistance($driverLat, $driverLng, $customerLat, $customerLng);
        return $distance <= $radiusKm;
    }

    /**
     * Get delivery zone info
     */
    public function getDeliveryZone($customerLat, $customerLng, $restaurantLat, $restaurantLng)
    {
        $distance = $this->calculateDistance($restaurantLat, $restaurantLng, $customerLat, $customerLng);
        
        // Calculate delivery fee based on distance
        $baseFee = 2.00;
        $perKmFee = 0.50;
        
        $deliveryFee = $baseFee + ($distance * $perKmFee);
        
        // Free delivery threshold
        $freeDeliveryThreshold = 15.00;
        if ($deliveryFee >= $freeDeliveryThreshold) {
            $deliveryFee = 0;
        }
        
        // Estimated time (assume 30 km/h average)
        $estimatedMinutes = round(($distance / 30) * 60);
        
        return array(
            'distance_km' => round($distance, 2),
            'distance_text' => round($distance, 1) . ' km',
            'delivery_fee' => round($deliveryFee, 2),
            'free_delivery' => $deliveryFee == 0,
            'estimated_minutes' => $estimatedMinutes,
            'estimated_time' => $estimatedMinutes . ' minutes',
            'in_zone' => $distance <= 10, // 10km delivery radius
        );
    }

    /**
     * Save location history to database
     */
    private function saveLocationHistory($driverId, $lat, $lng)
    {
        // This would save to a driver_locations table
        // Implementation depends on your database structure
        Log::info("Driver {$driverId} location: {$lat}, {$lng}");
    }

    /**
     * Parse address components
     */
    private function parseAddressComponents($components)
    {
        $parsed = array();
        
        foreach ($components as $component) {
            $types = $component['types'];
            
            if (in_array('street_number', $types)) {
                $parsed['street_number'] = $component['long_name'];
            }
            if (in_array('route', $types)) {
                $parsed['street'] = $component['long_name'];
            }
            if (in_array('locality', $types)) {
                $parsed['city'] = $component['long_name'];
            }
            if (in_array('administrative_area_level_1', $types)) {
                $parsed['state'] = $component['long_name'];
            }
            if (in_array('postal_code', $types)) {
                $parsed['zipcode'] = $component['long_name'];
            }
            if (in_array('country', $types)) {
                $parsed['country'] = $component['long_name'];
            }
        }
        
        return $parsed;
    }
}
