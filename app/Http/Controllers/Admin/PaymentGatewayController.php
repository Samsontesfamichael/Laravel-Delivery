<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of all payment gateways.
     */
    public function index()
    {
        $gateways = PaymentGateway::orderBy('sort_order')->get();
        return view('admin.payment-gateways.index', compact('gateways'));
    }

    /**
     * Show the form for creating a new payment gateway.
     */
    public function create()
    {
        return view('admin.payment-gateways.create');
    }

    /**
     * Store a newly created payment gateway.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_gateways',
            'code' => 'required|string|max:50|unique:payment_gateways',
            'type' => 'required|in:card,bank,mobile_money,wallet,crypto',
            'description' => 'nullable|string',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'merchant_id' => 'nullable|string',
            'public_key' => 'nullable|string',
            'private_key' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'callback_url' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'sort_order' => 'integer|min:0',
            'supported_currencies' => 'nullable|array',
            'exchange_rate' => 'nullable|numeric|min:0',
            'fixed_charge' => 'nullable|numeric|min:0',
            'percentage_charge' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('payment-logos', 'public');
        }

        // Encrypt sensitive data
        if (!empty($data['api_key'])) {
            $data['api_key'] = encrypt($data['api_key']);
        }
        if (!empty($data['api_secret'])) {
            $data['api_secret'] = encrypt($data['api_secret']);
        }
        if (!empty($data['merchant_id'])) {
            $data['merchant_id'] = encrypt($data['merchant_id']);
        }
        if (!empty($data['public_key'])) {
            $data['public_key'] = encrypt($data['public_key']);
        }
        if (!empty($data['private_key'])) {
            $data['private_key'] = encrypt($data['private_key']);
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_test_mode'] = $request->has('is_test_mode');
        
        PaymentGateway::create($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment gateway created successfully.');
    }

    /**
     * Display the specified payment gateway.
     */
    public function show(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.show', compact('paymentGateway'));
    }

    /**
     * Show the form for editing the specified payment gateway.
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.edit', compact('paymentGateway'));
    }

    /**
     * Update the specified payment gateway.
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_gateways,name,' . $paymentGateway->id,
            'code' => 'required|string|max:50|unique:payment_gateways,code,' . $paymentGateway->id,
            'type' => 'required|in:card,bank,mobile_money,wallet,crypto',
            'description' => 'nullable|string',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'merchant_id' => 'nullable|string',
            'public_key' => 'nullable|string',
            'private_key' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'callback_url' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'sort_order' => 'integer|min:0',
            'supported_currencies' => 'nullable|array',
            'exchange_rate' => 'nullable|numeric|min:0',
            'fixed_charge' => 'nullable|numeric|min:0',
            'percentage_charge' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($paymentGateway->logo) {
                storage()->delete('public/' . $paymentGateway->logo);
            }
            $data['logo'] = $request->file('logo')->store('payment-logos', 'public');
        }

        // Encrypt sensitive data (only if provided)
        if (!empty($data['api_key'])) {
            $data['api_key'] = encrypt($data['api_key']);
        }
        if (!empty($data['api_secret'])) {
            $data['api_secret'] = encrypt($data['api_secret']);
        }
        if (!empty($data['merchant_id'])) {
            $data['merchant_id'] = encrypt($data['merchant_id']);
        }
        if (!empty($data['public_key'])) {
            $data['public_key'] = encrypt($data['public_key']);
        }
        if (!empty($data['private_key'])) {
            $data['private_key'] = encrypt($data['private_key']);
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_test_mode'] = $request->has('is_test_mode');
        
        $paymentGateway->update($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment gateway updated successfully.');
    }

    /**
     * Toggle the status of the specified payment gateway.
     */
    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update(['is_active' => !$paymentGateway->is_active]);
        
        $status = $paymentGateway->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Payment gateway {$status}.");
    }

    /**
     * Remove the specified payment gateway.
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        // Delete logo if exists
        if ($paymentGateway->logo) {
            storage()->delete('public/' . $paymentGateway->logo);
        }
        
        $paymentGateway->delete();

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment gateway deleted successfully.');
    }

    /**
     * Update sort order for multiple payment gateways.
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'gateways' => 'required|array',
            'gateways.*.id' => 'required|exists:payment_gateways,id',
            'gateways.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->gateways as $gateway) {
            PaymentGateway::where('id', $gateway['id'])->update([
                'sort_order' => $gateway['sort_order']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated.']);
    }

    /**
     * Test the payment gateway connection.
     */
    public function testConnection(PaymentGateway $paymentGateway)
    {
        try {
            $result = $paymentGateway->testConnection();
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Connection successful!'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Connection failed.'
            ], 400);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update status for payment gateways.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'gateway_ids' => 'required|array',
            'gateway_ids.*' => 'exists:payment_gateways,id',
            'status' => 'required|boolean',
        ]);

        PaymentGateway::whereIn('id', $request->gateway_ids)->update([
            'is_active' => $request->status
        ]);

        $status = $request->status ? 'enabled' : 'disabled';
        return response()->json([
            'success' => true,
            'message' => "{$request->status} payment gateways {$status}."
        ]);
    }
}
