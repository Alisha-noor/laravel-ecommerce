<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    protected $fillable = ['order_id','status','note','happened_at'];

    protected $casts = [
        'happened_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
