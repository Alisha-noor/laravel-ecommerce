<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
   protected $fillable = [
    'name','email','phone','address','city','state','country','zip',
    'status','total','tracking_number','notes','delivered_date'
];


    protected $casts = [
        'delivered_date' => 'datetime',
    ];

    // Relations
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    // Accessors (optional niceties)
    public function getTaxAttribute(): float
    {
        // If your 'total' includes tax and 'subtotal' comes from items,
        // tax = total - subtotal (never negative).
        $subtotal = $this->subtotal ?? 0; // set by withSum() in the controller
        return max(0, (float) $this->total - (float) $subtotal);
    }

    public function getOrderNoAttribute(): string
    {
        return '1' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
