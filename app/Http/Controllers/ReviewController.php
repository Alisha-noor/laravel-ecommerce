<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        Review::create([
            'product_id' => $product_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'rating'     => $request->rating,
            'review'     => $request->review,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
