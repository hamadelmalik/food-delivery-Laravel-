<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionType extends Model
{
     protected $fillable = ['name'];
     public function options()
{
    return $this->hasMany(ProductOption::class, 'type_id');
}

}
