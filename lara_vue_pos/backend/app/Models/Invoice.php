<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'status',
        'amount',
        'sales_by',
        'desc',
    ];
}
