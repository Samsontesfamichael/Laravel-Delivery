<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_type',
        'name',
        'description',
        'price',
        'currency',
        'features',
        'max_orders',
        'max_products',
        'start_date',
        'end_date',
        'is_active',
        'is_trial',
        'trial_days',
        'status',
        'payment_method',
        'transaction_id',
        'payment_status',
        'auto_renew',
        'cancelled_at',
        'cancellation_reason',
        'paused_at',
        'resumed_at',
        'last_renewed_at',
        'renewal_count',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_trial' => 'boolean',
        'auto_renew' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'paused_at' => 'datetime',
        'resumed_at' => 'datetime',
        'last_renewed_at' => 'datetime',
        'max_orders' => 'integer',
        'max_products' => 'integer',
        'trial_days' => 'integer',
        'renewal_count' => 'integer',
        'price' => 'float',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription transactions.
     */
    public function transactions()
    {
        return $this->hasMany(SubscriptionTransaction::class);
    }

    /**
     * Check if subscription is active.
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->is_active && now()->lt($this->end_date);
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired()
    {
        return now()->gte($this->end_date);
    }

    /**
     * Check if subscription is in trial period.
     */
    public function isInTrial()
    {
        if (!$this->is_trial) {
            return false;
        }
        
        $trialEnd = $this->start_date->addDays($this->trial_days);
        return now()->lt($trialEnd);
    }

    /**
     * Get remaining days until expiration.
     */
    public function getRemainingDays()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->end_date);
    }

    /**
     * Check if user can place more orders.
     */
    public function canPlaceOrder()
    {
        if (!$this->isActive()) {
            return false;
        }
        
        if ($this->max_orders === -1) {
            return true;
        }
        
        // Count user's orders in this subscription period
        $orderCount = $this->user->orders()
            ->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->count();
        
        return $orderCount < $this->max_orders;
    }

    /**
     * Check if user can add more products.
     */
    public function canAddProduct()
    {
        if (!$this->isActive()) {
            return false;
        }
        
        if ($this->max_products === -1) {
            return true;
        }
        
        $productCount = $this->user->products()->count();
        
        return $productCount < $this->max_products;
    }

    /**
     * Scope to get active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('is_active', true)
            ->where('end_date', '>', now());
    }

    /**
     * Scope to get expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<=', now())
            ->orWhere('status', 'expired');
    }

    /**
     * Scope to get subscriptions by plan type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('plan_type', $type);
    }

    /**
     * Scope to get subscriptions expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->active()
            ->where('end_date', '<=', now()->addDays($days));
    }
}
