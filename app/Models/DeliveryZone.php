<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryZone extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'delivery_type',
        'center_latitude',
        'center_longitude',
        'radius_km',
        'polygon_coordinates',
        'postal_codes',
        'base_delivery_fee',
        'per_km_fee',
        'minimum_order_amount',
        'free_delivery_threshold',
        'maximum_delivery_distance',
        'estimated_delivery_time',
        'is_active',
        'is_default',
        'extra_charges',
        'working_hours',
    ];

    protected $casts = [
        'center_latitude' => 'float',
        'center_longitude' => 'float',
        'radius_km' => 'float',
        'base_delivery_fee' => 'float',
        'per_km_fee' => 'float',
        'minimum_order_amount' => 'float',
        'free_delivery_threshold' => 'float',
        'maximum_delivery_distance' => 'float',
        'estimated_delivery_time' => 'integer',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'polygon_coordinates' => 'array',
        'postal_codes' => 'array',
        'extra_charges' => 'array',
        'working_hours' => 'array',
    ];

    /**
     * Check if a point is within this delivery zone.
     */
    public function containsPoint($latitude, $longitude)
    {
        return match($this->delivery_type) {
            'radius' => $this->isWithinRadius($latitude, $longitude),
            'polygon' => $this->isWithinPolygon($latitude, $longitude),
            'postal_code' => $this->isPostalCodeCovered($latitude, $longitude),
            default => false,
        };
    }

    /**
     * Check if point is within radius.
     */
    public function isWithinRadius($latitude, $longitude)
    {
        $distance = $this->calculateDistance(
            $this->center_latitude,
            $this->center_longitude,
            $latitude,
            $longitude
        );

        return $distance <= $this->radius_km;
    }

    /**
     * Check if point is within polygon using ray casting algorithm.
     */
    public function isWithinPolygon($latitude, $longitude)
    {
        $coordinates = $this->polygon_coordinates;
        
        if (empty($coordinates)) {
            return false;
        }

        $vertices = count($coordinates);
        $x = $latitude;
        $y = $longitude;

        $inside = false;

        for ($i = 0, $j = $vertices - 1; $i < $vertices; $j = $i++) {
            $xi = $coordinates[$i]['lat'];
            $yi = $coordinates[$i]['lng'];
            $xj = $coordinates[$j]['lat'];
            $yj = $coordinates[$j]['lng'];

            $intersect = (($yi > $y) !== ($yj > $y)) &&
                ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    /**
     * Check if postal code is covered (requires reverse geocoding).
     */
    public function isPostalCodeCovered($latitude, $longitude)
    {
        // This would typically use reverse geocoding to get postal code
        // For now, return false as it requires external API
        return false;
    }

    /**
     * Calculate distance between two points using Haversine formula.
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Calculate delivery fee for a given location.
     */
    public function calculateFee($latitude, $longitude, $orderAmount = 0)
    {
        $fee = $this->base_delivery_fee;

        // Check minimum order requirement
        if ($this->minimum_order_amount && $orderAmount < $this->minimum_order_amount) {
            return [
                'available' => false,
                'reason' => 'Minimum order amount not met',
                'minimum_required' => $this->minimum_order_amount,
            ];
        }

        // Check maximum delivery distance
        if ($this->delivery_type === 'radius') {
            $distance = $this->calculateDistance(
                $this->center_latitude,
                $this->center_longitude,
                $latitude,
                $longitude
            );

            if ($this->maximum_delivery_distance && $distance > $this->maximum_delivery_distance) {
                return [
                    'available' => false,
                    'reason' => 'Location too far from delivery zone',
                    'maximum_distance' => $this->maximum_delivery_distance,
                    'distance' => $distance,
                ];
            }

            // Calculate per km fee
            if ($this->per_km_fee > 0) {
                $fee += $distance * $this->per_km_fee;
            }
        }

        // Apply free delivery threshold
        if ($this->free_delivery_threshold && $orderAmount >= $this->free_delivery_threshold) {
            $fee = 0;
        }

        // Calculate extra charges
        $extraCharges = [];
        if ($this->extra_charges) {
            foreach ($this->extra_charges as $charge) {
                $amount = $charge['type'] === 'percentage'
                    ? ($orderAmount * $charge['amount'] / 100)
                    : $charge['amount'];
                $extraCharges[] = [
                    'name' => $charge['name'],
                    'amount' => $amount,
                ];
                $fee += $amount;
            }
        }

        return [
            'available' => true,
            'base_fee' => $this->base_delivery_fee,
            'distance_fee' => isset($distance) ? $distance * ($this->per_km_fee ?? 0) : 0,
            'extra_charges' => $extraCharges,
            'total_fee' => $fee,
            'currency' => config('app.currency', 'USD'),
            'estimated_time' => $this->estimated_delivery_time,
        ];
    }

    /**
     * Check if currently within working hours.
     */
    public function isWithinWorkingHours()
    {
        $workingHours = $this->working_hours;
        
        if (empty($workingHours)) {
            return true; // Always open if no working hours set
        }

        $now = now();
        $currentDay = $now->dayOfWeek;
        $currentTime = $now->format('H:i');

        foreach ($workingHours as $hours) {
            if ($hours['day'] == $currentDay && $hours['is_active']) {
                if ($currentTime >= $hours['start'] && $currentTime <= $hours['end']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the formatted working hours.
     */
    public function getFormattedWorkingHours()
    {
        $workingHours = $this->working_hours;
        
        if (empty($workingHours)) {
            return '24/7';
        }

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $formatted = [];

        foreach ($workingHours as $hours) {
            if ($hours['is_active']) {
                $formatted[] = $days[$hours['day']] . ': ' . $hours['start'] . ' - ' . $hours['end'];
            }
        }

        return implode(', ', $formatted);
    }

    /**
     * Scope to get active zones.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get default zone.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Find available zone for given coordinates.
     */
    public static function findAvailableZone($latitude, $longitude)
    {
        $zones = self::active()->get();
        
        foreach ($zones as $zone) {
            if ($zone->containsPoint($latitude, $longitude)) {
                return $zone;
            }
        }

        // Return default zone if available
        return self::active()->default()->first();
    }
}
