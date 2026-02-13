<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DeliveryZoneService;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    protected $zoneService;

    public function __construct(DeliveryZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }

    public function checkDelivery(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $result = $this->zoneService->isDeliverable(
            $request->latitude,
            $request->longitude
        );

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function calculateFee(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $result = $this->zoneService->calculateDeliveryFee(
            $request->latitude,
            $request->longitude
        );

        return response()->json(['success' => true, 'data' => $result]);
    }
}
