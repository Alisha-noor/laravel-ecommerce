<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Add effective price
        $query->select('*')
              ->selectRaw('COALESCE(NULLIF(sale_price, 0), regular_price) as effective_price');

        // 🔍 Search by name or description
        if ($request->filled('name')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                  ->orWhere('description', 'like', '%' . $request->name . '%');
            });
        }

        // 🏷️ Filter by category
        if ($request->has('category')) {
            $query->whereIn('category_id', (array) $request->category);
        }

        // 💵 Price range filtering
        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(NULLIF(sale_price, 0), regular_price) >= ?', [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(NULLIF(sale_price, 0), regular_price) <= ?', [$request->max_price]);
        }

        // 🔃 Sorting
        if ($request->sort === 'low_high') {
            $query->orderBy('effective_price', 'asc');
        } elseif ($request->sort === 'high_low') {
            $query->orderBy('effective_price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 📦 Get products with pagination
        $products = $query->paginate(20)->appends($request->query());

        return view('shop', compact('products'));
    }

    // public function product_details($product_slug)
    // {
    //     $product = Product::where('slug', $product_slug)->firstOrFail();

    //     $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();

    //     return view('details', compact('product', 'rproducts'));
    // }
    public function product_details($product_slug)
{
    $product = Product::where('slug', $product_slug)->firstOrFail();

    // Split gallery images into array
    $gallery = [];
    if (!empty($product->images)) {
        $gallery = explode(',', $product->images);
    }

    $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();

    return view('details', compact('product', 'gallery', 'rproducts'));
}

}
