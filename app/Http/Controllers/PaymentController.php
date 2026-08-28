<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {
    }

   public function createPayment(Request $request)
{
    try {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        $payment = $this->paymentService->createPayment(
            $order,
            $request->payment_method
        );

        return response()->json([
            'status' => true,
            'message' => 'Payment created successfully',
            'payment' => $payment,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}
}
