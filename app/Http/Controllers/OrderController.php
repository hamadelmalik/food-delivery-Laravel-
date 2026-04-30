<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    // 🟢 حفظ طلب جديد
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'total' => 'nullable|numeric',
        ]);

        // 1️⃣ إنشاء order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $request->total ?? 0,
            'taxes' => $request->taxes ?? 0,
            'delivery_fees' => $request->delivery_fees ?? 0,
            'payment_method' => $request->payment_method,
            'save_card' => $request->save_card ?? false,
            'transaction_id' => $request->transaction_id,
            'estimated_delivery_time' => $request->estimated_delivery_time,
        ]);

        // 2️⃣ حفظ items في order_items
        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'spicy' => $item['spicy'] ?? 0,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order saved successfully',
            'order' => $order->load('items'),
        ], 201);
    }

    // 🟢 كل الطلبات
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'status' => true,
            'orders' => $orders,
        ]);
    }

    // 🟢 تفاصيل طلب واحد
    public function show($id)
    {
        $order = Order::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'order' => $order,
        ]);
    }
}
