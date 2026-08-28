<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'taxes',
        'delivery_fees',
        'payment_method',
        'transaction_id',
        'estimated_delivery_time',
        'status',
    ];

    protected $casts = [

        'total' => 'double',
        'taxes' => 'double',
        'delivery_fees' => 'double',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
