<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'taxes',
        'delivery_fees',
        'total',
        'payment_method',
        'save_card',
        'transaction_id',
        'estimated_delivery_time',
    ];

    protected $casts = [
        'save_card' => 'boolean',
    ];

    // 🟢 relation
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
