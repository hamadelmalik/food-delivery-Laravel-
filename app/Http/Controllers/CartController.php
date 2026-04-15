<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // 🛒 عرض محتويات السلة
 public function index()
{
    $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

    $items = $cart->items()->with('product')->get();

    $finalItems = $items->groupBy('product_id')->map(function($group) {
        $first = $group->first();
        $totalQuantity = $group->sum('quantity');
        $unitPrice = $first->unit_price ?? ($first->product->price ?? 0);

        return [
            'item_id' => $first->id,
            'product_id' => $first->product_id,
            'name' => $first->product->name ?? 'Unknown',
            'image' => $first->product->image ?? null,
            'quantity' => $totalQuantity,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice,  // السعر مرة واحدة لكل منتج
            'spicy' => $first->spicy ?? 0,
            'option_type_id' => null,
            'option_id' => null,
        ];
    })->values();

    $totalPrice = $finalItems->sum('total_price'); // مجموع كل المنتجات

    return response()->json([
        'code' => 200,
        'message' => 'CART LOADED',
        'data' => [
            'total_price' => $totalPrice,
            'items' => $finalItems,
        ],
    ]);
}
    // ➕ إضافة عناصر للسلة
    public function add(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.quantity'       => 'nullable|integer|min:1',
            'items.*.spicy'          => 'nullable|numeric|min:0|max:5',
            'items.*.option_type_id' => 'nullable|integer|exists:option_types,id',
            'items.*.option_id'      => 'nullable|integer|exists:options,id',
        ]);

        try {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            foreach ($request->items as $item) {
                $product   = Product::find($item['product_id']);
                $unitPrice = $product->price ?? 0;
                $quantity  = $item['quantity'] ?? 1;

                // البحث عن المنتج بنفس الخيارات
                $existingItem = $cart->items()
                    ->where('product_id', $item['product_id'])
                    ->where('option_type_id', $item['option_type_id'] ?? null)
                    ->where('option_id', $item['option_id'] ?? null)
                    ->first();

                if ($existingItem) {
                    // لو موجود، نزود الكمية
                    $existingItem->update([
                        'quantity'    => $existingItem->quantity + $quantity,
                        'total_price' => $unitPrice * ($existingItem->quantity + $quantity),
                        'spicy'       => $item['spicy'] ?? $existingItem->spicy,
                    ]);
                } else {
                    // لو مش موجود، نعمل create جديد
                    $cart->items()->create([
                        'product_id'     => $item['product_id'],
                        'quantity'       => $quantity,
                        'spicy'          => $item['spicy'] ?? 0,
                        'option_type_id' => $item['option_type_id'] ?? null,
                        'option_id'      => $item['option_id'] ?? null,
                        'unit_price'     => $unitPrice,
                        'total_price'    => $unitPrice * $quantity,
                    ]);
                }
            }

            return $this->index();

        } catch (\Exception $e) {
            \Log::error('Add to cart error: '.$e->getMessage());
            return response()->json([
                'code'    => 500,
                'message' => 'Server error: '.$e->getMessage(),
            ], 500);
        }
    }

    // ✏️ تحديث عنصر في السلة
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity'       => 'nullable|integer|min:1',
            'spicy'          => 'nullable|numeric|min:0|max:5',
            'option_type_id' => 'nullable|integer|exists:option_types,id',
            'option_id'      => 'nullable|integer|exists:options,id',
        ]);

        $item    = CartItem::findOrFail($id);
        $product = $item->product;

        $item->update([
            'quantity'       => $request->quantity ?? $item->quantity,
            'spicy'          => $request->spicy ?? $item->spicy,
            'option_type_id' => $request->option_type_id ?? $item->option_type_id,
            'option_id'      => $request->option_id ?? $item->option_id,
            'unit_price'     => $product->price ?? 0,
            'total_price'    => ($product->price ?? 0) * ($request->quantity ?? $item->quantity),
        ]);

        return $this->index();
    }

    // ❌ حذف عنصر من السلة
    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return $this->index();
    }

    // 🧹 تفريغ السلة بالكامل
    public function clear()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->items()->delete();

        return $this->index();
    }
}
