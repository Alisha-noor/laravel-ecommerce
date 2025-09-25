<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
       use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',  // 0 = visible, 1 = hidden
    ];

    /**
     * Relationship: A brand can have many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
