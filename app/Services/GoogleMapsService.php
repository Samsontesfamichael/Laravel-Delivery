<?php

namespace App\Services;

use Google\Client as Google_Client;
use GuzzleHttp\Client;

class GoogleMapsService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = config('services.google.maps.api_key');
        $this->client = new Client();
    }

    /**
     * Get distance between two points
     */
    public function getDistance($origin, $destination, $mode = 'driving')
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'origins' => $origin,
                'destinations' => $destination,
                'mode' => $mode,
                'key' => $this->apiKey
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        
        if (isset($data['rows'][0]['elements'][0])) {
            $element = $data['rows'][0]['elements'][0];
            
            if ($element['status'] === 'OK') {
                return [
                    'distance' => $element['distance'],
                    'duration' => $element['duration']
                ];
            }
        }

        return null;
    }

    /**
     * Get directions between two points
     */
    public function getDirections($origin, $destination, $mode = 'driving')
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'origin' => $origin,
                'destination' => $destination,
                'mode' => $mode,
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get coordinates from address (geocoding)
     */
    public function geocode($address)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'address' => $address,
                'key' => $this->apiKey
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        
        if (isset($data['results'][0]['geometry']['location'])) {
            return $data['results'][0]['geometry']['location'];
        }

        return null;
    }

    /**
     * Get address from coordinates (reverse geocoding)
     */
    public function reverseGeocode($lat, $lng)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'latlng' => "$lat,$lng",
                'key' => $this->apiKey
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        
        if (isset($data['results'][0])) {
            return $data['results'][0];
        }

        return null;
    }

    /**
     * Get nearby places
     */
    public function getNearbyPlaces($lat, $lng, $radius = 5000, $type = 'restaurant')
    {
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'location' => "$lat,$lng",
                'radius' => $radius,
                'type' => $type,
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get place details
     */
    public function getPlaceDetails($placeId)
    {
        $url = "https://maps.googleapis.com/maps/api/place/details/json";
        
        $response = $this->client->get($url, [
            'query' => [
                'place_id' => $placeId,
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
