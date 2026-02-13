<?php

namespace App\Services;

class SubscriptionService
{
    public function getPlans()
    {
        return [
            ['id' => 1, 'name' => 'Basic', 'price' => 29.99, 'billing_period' => 'monthly'],
            ['id' => 2, 'name' => 'Pro', 'price' => 49.99, 'billing_period' => 'monthly'],
            ['id' => 3, 'name' => 'Enterprise', 'price' => 99.99, 'billing_period' => 'monthly'],
        ];
    }

    public function subscribe($restaurantId, $planId)
    {
        return ['success' => true, 'message' => 'Subscribed successfully'];
    }

    public function cancelSubscription($restaurantId)
    {
        return ['success' => true, 'message' => 'Subscription cancelled'];
    }
}
