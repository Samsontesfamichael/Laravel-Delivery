<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function getGateways()
    {
        return response()->json([
            'success' => true,
            'data' => $this->paymentService->getGateways(),
        ]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'gateway' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'order_id' => 'required|string',
        ]);

        $result = $this->paymentService->processPayment(
            $request->gateway,
            $request->all()
        );

        return response()->json($result);
    }
}
