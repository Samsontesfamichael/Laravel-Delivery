<?php

namespace App\Services;

class DeliveryZoneService
{
    public function isDeliverable($lat, $lng, $restaurantId = null)
    {
        return ['deliverable' => true, 'zone_name' => 'Default Zone', 'delivery_fee' => 2.50];
    }

    public function calculateDeliveryFee($lat, $lng)
    {
        return ['deliverable' => true, 'delivery_fee' => 2.50, 'minimum_order' => 10];
    }

    public function getAllZones($restaurantId = null)
    {
        return [];
    }
}
