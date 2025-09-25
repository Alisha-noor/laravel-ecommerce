<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cart = $this->getUserCart();
        $cartItems = $cart->items()->with('product')->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $tax = $subtotal * 0.1; // example: 10% tax
        $discount = session('coupon.discount') ?? 0;
        $total = $subtotal + $tax - $discount;

        return view('cart', compact('cartItems', 'subtotal', 'tax', 'discount', 'total'));
    }

    // Add to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getUserCart();
        $product = Product::findOrFail($request->product_id);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'price'      => $product->sale_price ?: $product->regular_price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    // Increase quantity
    public function increaseQty(CartItem $item)
    {
        $item->increment('quantity');
        return back();
    }

    // Decrease quantity
    public function decreaseQty(CartItem $item)
    {
        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }
        return back();
    }

    // Remove item
    public function remove(CartItem $item)
    {
        $item->delete();
        return back();
    }

    // Utility: Get or create cart
    private function getUserCart()
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status'  => 'active',
        ]);
    }

    // Apply coupon
    public function apply_coupon_code(Request $request)
    {
        $request->validate(['code' => 'required|string|max:255']);
        $code = strtoupper(trim($request->input('code')));

        $coupon = Coupon::whereRaw('UPPER(code) = ?', [$code])->first();

        if (!$coupon) {
            return back()->withErrors('Invalid coupon code.');
        }

        if (!empty($coupon->expiry_date) && Carbon::parse($coupon->expiry_date)->isPast()) {
            return back()->withErrors('Coupon has expired.');
        }

        $cart = $this->getUserCart();
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $tax = $subtotal * 0.1;

        $minRequired = (float) ($coupon->cart_min_value ?? $coupon->cart_value ?? 0);
        if ($subtotal < $minRequired) {
            return back()->withErrors('Minimum cart value for this coupon is ' . number_format($minRequired, 2));
        }

        $discount = $coupon->type === 'percent'
            ? round($subtotal * ($coupon->value / 100), 2)
            : round(min($coupon->value, $subtotal), 2);

        $newSubtotal = max(0, $subtotal - $discount);
        $newTotal = round($newSubtotal + $tax, 2);

        session([
            'coupon' => [
                'id'       => $coupon->id,
                'code'     => $coupon->code,
                'type'     => $coupon->type,
                'value'    => $coupon->value,
                'discount' => $discount,
            ],
            'checkout' => [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax'      => $tax,
                'total'    => $newTotal,
            ],
        ]);

        return back()->with('success', 'Coupon applied.');
    }

    public function remove_coupon()
    {
        session()->forget(['coupon', 'checkout']);
        return back()->with('success', 'Coupon removed.');
    }

    // Checkout
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::id())->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    // Place order
    public function place_order(Request $request)
    {
        $user_id = Auth::id();

        // Get default address or create one
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();
        if (!$address) {
            $request->validate([
                'name'     => 'required|max:100',
                'phone'    => 'required|numeric',
                'zip'      => 'required|numeric',
                'state'    => 'required',
                'city'     => 'required',
                'address'  => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);
            $address = Address::create([
                'user_id'   => $user_id,
                'name'      => $request->name,
                'phone'     => $request->phone,
                'zip'       => $request->zip,
                'state'     => $request->state,
                'city'      => $request->city,
                'address'   => $request->address,
                'locality'  => $request->locality,
                'landmark'  => $request->landmark,
                'country'   => '',
                'isdefault' => true,
            ]);
        }

        $cart = $this->getUserCart();
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $tax = $subtotal * 0.1;
        $discount = session('coupon.discount') ?? 0;
        $total = $subtotal + $tax - $discount;

        $order = Order::create([
            'user_id'  => $user_id,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax'      => $tax,
            'total'    => $total,
            'name'     => $address->name,
            'phone'    => $address->phone,
            'locality' => $address->locality,
            'address'  => $address->address,
            'city'     => $address->city,
            'state'    => $address->state,
            'country'  => $address->country,
            'landmark' => $address->landmark,
            'zip'      => $address->zip,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'sku'      => $item->product_id,
                'name'     => $item->product->name ?? '',
                'qty'      => $item->quantity,
                'price'    => $item->price,
                'total'    => $item->price * $item->quantity,
            ]);
        }

        Transaction::create([
            'user_id'  => $user_id,
            'order_id' => $order->id,
            'mode'     => $request->input('mode', 'cod'),
            'status'   => 'pending',
        ]);

        // clear cart
        $cart->items()->delete();
        $cart->delete();
        session()->forget(['checkout', 'coupon']);

        return redirect()->route('cart.confirmation');
    }

    public function confirmation()
    {
        return view('order-confirmation');
    }
}
