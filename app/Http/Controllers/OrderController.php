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

        $order = Order::create([
            'user_id' => Auth::id(),
            'items' => $request->items, // مصفوفة JSON فيها المنتجات + toppings + side options
            'total' => $request->total,
            'taxes' => $request->taxes ?? 0,
            'delivery_fees' => $request->delivery_fees ?? 0,
            'payment_method' => $request->payment_method ?? null,
            'save_card' => $request->save_card ?? false,
            'transaction_id' => $request->transaction_id ?? null,
            'estimated_delivery_time' => $request->estimated_delivery_time ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order saved successfully',
            'order' => $order,
        ], 201);
    }

    // 🟢 جلب كل الطلبات الخاصة بالمستخدم
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => true,
            'orders' => $orders,
        ]);
    }

    // 🟢 جلب تفاصيل طلب معين
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        return response()->json([
            'status' => true,
            'order' => $order,
        ]);
    }
}
