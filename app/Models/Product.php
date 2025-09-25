<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'price', 'brand_id', 'sku'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
