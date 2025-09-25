<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// App\Models\Coupon.php
// app/Models/Coupon.php
class Coupon extends Model
{
    protected $fillable = ['code','type','value','cart_min_value','cart_value','expiry_date'];
    protected $casts = [
        'value'          => 'decimal:2',
        'cart_min_value' => 'decimal:2',
        'cart_value'     => 'decimal:2',
        'expiry_date'    => 'datetime',
    ];
}
