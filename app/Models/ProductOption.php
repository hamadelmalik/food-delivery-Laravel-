<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
     protected $fillable = [
         'name',
        'type_id', // ✅ الصح
        'price',
        'image',
    ];

    public function optionType()
    {
           return $this->belongsTo(OptionType::class, 'type_id');

    }



}
