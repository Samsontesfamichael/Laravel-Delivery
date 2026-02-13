<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function getPlans()
    {
        return response()->json([
            'success' => true,
            'data' => $this->subscriptionService->getPlans(),
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|integer',
            'plan_id' => 'required|integer',
        ]);

        $result = $this->subscriptionService->subscribe(
            $request->restaurant_id,
            $request->plan_id
        );

        return response()->json($result);
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|integer',
        ]);

        $result = $this->subscriptionService->cancelSubscription(
            $request->restaurant_id
        );

        return response()->json($result);
    }
}
