<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'image',
        'images',
        'category_id',
        'brand_id',
    ];

    /**
     * Relationship: A product belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: A product belongs to a brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
