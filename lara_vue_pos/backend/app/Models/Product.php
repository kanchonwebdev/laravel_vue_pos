<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'qty',
        'sku',
        'max_order',
        'unit',
        'category',
        'promo_code',
        'image',
        'desc',
    ];
}
