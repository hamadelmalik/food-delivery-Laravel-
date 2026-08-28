<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // =========================
        // Validation
        // =========================

        $validated = $request->validate([
            'items' => 'required|array|min:1',

            'items.*.product_id' =>
                'required|exists:products,id',

            'items.*.quantity' =>
                'required|integer|min:1',

            'items.*.spicy' =>
                'nullable|numeric|min:0',

            // Options
            'items.*.options' =>
                'nullable|array',

            'items.*.options.*.option_type_id' =>
                'required|exists:option_types,id',

            'items.*.options.*.option_id' =>
                'required|exists:product_options,id',

            // Order data
            'payment_method' =>
                'nullable|string',

            'transaction_id' =>
                'nullable|string',

            'delivery_fees' =>
                'nullable|numeric|min:0',

            'taxes' =>
                'nullable|numeric|min:0',

            'estimated_delivery_time' =>
                'nullable|string',
        ]);

        Log::info('================ ORDER REQUEST ================');
        Log::info($validated);

        try {

            $order = DB::transaction(function () use ($validated) {

                $subtotal = 0;

                // =====================================
                // Calculate subtotal
                // =====================================

                foreach ($validated['items'] as $item) {

                    $product = Product::findOrFail(
                        $item['product_id']
                    );

                    // Product price
                    $subtotal +=
                        $product->price *
                        $item['quantity'];

                    // Options price
                    foreach ($item['options'] ?? [] as $optionData) {

                        $option = ProductOption::findOrFail(
                            $optionData['option_id']
                        );

                        $subtotal +=
                            $option->price *
                            $item['quantity'];
                    }
                }

                // =====================================
                // Fees
                // =====================================

                $taxes =
                    $validated['taxes'] ?? 0;

                $deliveryFees =
                    $validated['delivery_fees'] ?? 0;

                $total =
                    $subtotal +
                    $taxes +
                    $deliveryFees;

                // =====================================
                // Create Order
                // =====================================

                $order = Order::create([

                    'user_id' =>
                        Auth::id(),

                    'total' =>
                        $total,

                    'taxes' =>
                        $taxes,

                    'delivery_fees' =>
                        $deliveryFees,

                    'payment_method' =>
                        $validated['payment_method'] ?? null,

                    'transaction_id' =>
                        $validated['transaction_id'] ?? null,

                    'estimated_delivery_time' =>
                        $validated['estimated_delivery_time'] ?? null,

                    'status' =>
                        'pending',
                ]);

                // =====================================
                // Create Order Items
                // =====================================

                foreach ($validated['items'] as $item) {

                    $product = Product::findOrFail(
                        $item['product_id']
                    );

                    // ---------------------------------
                    // Main Product
                    // ---------------------------------

                    $order->items()->create([

                        'product_id' =>
                            $product->id,

                        'quantity' =>
                            $item['quantity'],

                        'base_price' =>
                            $product->price,

                        'option_type_id' =>
                            null,

                        'option_id' =>
                            null,

                        'option_price' =>
                            0,

                        'total_price' =>
                            $product->price *
                            $item['quantity'],

                        'spicy' =>
                            $item['spicy'] ?? 0,
                    ]);

                    // ---------------------------------
                    // Product Options
                    // ---------------------------------

                    foreach (
                        $item['options'] ?? []
                        as $optionData
                    ) {

                        $option =
                            ProductOption::findOrFail(
                                $optionData['option_id']
                            );

                        $order->items()->create([

                            'product_id' =>
                                $product->id,

                            'quantity' =>
                                $item['quantity'],

                            'base_price' =>
                                $product->price,

                            'option_type_id' =>
                                $optionData['option_type_id'],

                            'option_id' =>
                                $option->id,

                            'option_price' =>
                                $option->price,

                            'total_price' =>
                                $option->price *
                                $item['quantity'],

                            'spicy' =>
                                $item['spicy'] ?? 0,
                        ]);
                    }
                }

                return $order;
            });

            // =====================================
            // Load relationships
            // =====================================

            $order->load('items');

            // =====================================
            // Log
            // =====================================

            Log::info(
                '================ ORDER CREATED ================'
            );

            Log::info($order->toArray());

            // =====================================
            // Response
            // =====================================

            return response()->json([
                'status' => true,
                'message' => 'Order saved successfully',
                'order' => $order,
            ], 201);

        } catch (\Throwable $e) {

            Log::error(
                '================ CREATE ORDER ERROR ================'
            );

            Log::error($e->getMessage());

            Log::error($e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
