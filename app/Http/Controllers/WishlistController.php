<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')
            ->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate(\App\Models\Product::class);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function index()
    {
        $cartItems = Cart::instance('wishlist')->content();
        return view('wishlist', compact('cartItems'));
    }

    public function remove_item_from_wishlist($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from wishlist!');
    }

    public function empty_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'Wishlist cleared!');
    }

    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);

        // remove from wishlist
        Cart::instance('wishlist')->remove($rowId);

        // add to cart
        Cart::instance('cart')
            ->add($item->id, $item->name, 1, $item->price)
            ->associate(\App\Models\Product::class);

        return redirect()->back()->with('success', 'Item moved to cart!');
    }
}
