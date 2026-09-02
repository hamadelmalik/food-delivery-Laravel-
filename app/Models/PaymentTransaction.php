<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'gateway',
    ];

    protected $casts = [
        'amount' => 'double',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
