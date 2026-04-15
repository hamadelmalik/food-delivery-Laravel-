<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'spicy',
        'options',
        'unit_price',
        'total_price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // علاقة إضافية لو عندك جدول cart_item_options
    public function itemOptions()
    {
        return $this->hasMany(CartItemOption::class);
    }

    // حساب السعر الكلي أوتوماتيك
    public function getTotalPriceAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}
