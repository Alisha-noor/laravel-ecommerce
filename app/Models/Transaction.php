<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    // In app/Models/Transaction.php
    protected $fillable = [
        'order_id',
        'user_id',
        'mode', 
        'status',
        'amount'
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
