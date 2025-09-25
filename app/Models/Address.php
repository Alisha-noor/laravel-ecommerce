<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // Allow mass assignment for these columns
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zip',
        'state',
        'city',
        'address',
        'locality',
        'landmark',
        'country',
        'isdefault',
    ];

    // Helpful casting
    protected $casts = [
        'isdefault' => 'boolean',
        'user_id'   => 'integer',
    ];
}
