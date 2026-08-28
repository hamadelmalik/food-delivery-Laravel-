<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'base_price',
        'option_type_id',
        'option_id',
        'option_price',
        'total_price',
        'spicy',
    ];

    protected $casts = [
        'base_price' => 'double',
        'option_price' => 'double',
        'total_price' => 'double',
        'spicy' => 'double',
    ];

    public function optionType()
{
    return $this->belongsTo(\App\Models\OptionType::class, 'option_type_id');
}

public function option()
{
    return $this->belongsTo(\App\Models\ProductOption::class, 'option_id');
}
}
