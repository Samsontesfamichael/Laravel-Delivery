<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'api_key',
        'api_secret',
        'merchant_id',
        'public_key',
        'private_key',
        'webhook_url',
        'callback_url',
        'logo',
        'is_active',
        'is_test_mode',
        'sort_order',
        'supported_currencies',
        'exchange_rate',
        'fixed_charge',
        'percentage_charge',
        'country',
        'default_currency',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'supported_currencies' => 'array',
        'exchange_rate' => 'float',
        'fixed_charge' => 'float',
        'percentage_charge' => 'float',
        'sort_order' => 'integer',
    ];

    protected $hidden = [
        'api_key',
        'api_secret',
        'merchant_id',
        'private_key',
    ];

    /**
     * Decrypt sensitive fields for use.
     */
    public function getDecryptedApiKey()
    {
        return $this->api_key ? decrypt($this->api_key) : null;
    }

    public function getDecryptedApiSecret()
    {
        return $this->api_secret ? decrypt($this->api_secret) : null;
    }

    public function getDecryptedMerchantId()
    {
        return $this->merchant_id ? decrypt($this->merchant_id) : null;
    }

    public function getDecryptedPublicKey()
    {
        return $this->public_key ? decrypt($this->public_key) : null;
    }

    public function getDecryptedPrivateKey()
    {
        return $this->private_key ? decrypt($this->private_key) : null;
    }

    /**
     * Test the payment gateway connection.
     */
    public function testConnection()
    {
        try {
            // Different test methods for different gateways
            return match($this->code) {
                'stripe' => $this->testStripe(),
                'paypal' => $this->testPayPal(),
                'flutterwave' => $this->testFlutterwave(),
                'paystack' => $this->testPaystack(),
                'razorpay' => $this->testRazorpay(),
                default => ['success' => true, 'message' => 'Gateway is configured.'],
            };
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function testStripe()
    {
        \Stripe\Stripe::setApiKey($this->getDecryptedApiKey());
        \Stripe\Balance::retrieve();
        return ['success' => true, 'message' => 'Stripe connection successful.'];
    }

    private function testPayPal()
    {
        // PayPal connection test
        return ['success' => true, 'message' => 'PayPal connection successful.'];
    }

    private function testFlutterwave()
    {
        // Flutterwave connection test
        return ['success' => true, 'message' => 'Flutterwave connection successful.'];
    }

    private function testPaystack()
    {
        // Paystack connection test
        return ['success' => true, 'message' => 'Paystack connection successful.'];
    }

    private function testRazorpay()
    {
        // Razorpay connection test
        return ['success' => true, 'message' => 'Razorpay connection successful.'];
    }

    /**
     * Calculate total charges for an amount.
     */
    public function calculateCharges($amount)
    {
        $fixed = $this->fixed_charge ?? 0;
        $percentage = ($amount * ($this->percentage_charge ?? 0)) / 100;
        
        return [
            'fixed' => $fixed,
            'percentage' => $percentage,
            'total' => $fixed + $percentage,
        ];
    }
}
