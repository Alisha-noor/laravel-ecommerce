<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
class CheckoutController extends Controller
{
    public function edit($id)
    {
        $address = Address::findOrFail($id);
        return view('addressedit', compact('address'));
    }
    public function destroy($id)
    {
        $address = \App\Models\Address::findOrFail($id);

        // Optional: make sure only the logged-in user can delete their own address
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $address->delete();

        return redirect()->route('userprofile')->with('success', 'Address deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        $address = Address::findOrFail($id);
        $address->update($request->all());

        return redirect()->route('userprofile')->with('success', 'Address updated successfully!');
    }


    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:COD,CARD',
            'card_name' => 'required_if:mode,CARD|string|max:255',
            'card_number' => 'required_if:mode,CARD|string|max:19',
            'expiry' => 'required_if:mode,CARD|string|max:5',
            'cvv' => 'required_if:mode,CARD|string|max:4',
            'card_type' => 'required_if:mode,CARD|string|max:20',
            // Add shipping fields validation
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'locality' => 'required|string|max:100',
            'landmark' => 'nullable|string|max:255',
        ]);

        $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->firstOrFail();
        $cart->update([
            'payment_mode' => $validated['mode'],
            'card_name' => $validated['card_name'] ?? null,
            'card_number' => $validated['card_number'] ?? null, // ideally store last 4 digits only
            'expiry' => $validated['expiry'] ?? null,
            'cvv' => $validated['cvv'] ?? null,
            'card_type' => $validated['card_type'] ?? null,
            'status' => 'placed',
            // You can also store shipping info here
            'shipping_name' => $validated['name'],
            'shipping_phone' => $validated['phone'],
            'shipping_address' => $validated['address'],
            'shipping_city' => $validated['city'],
            'shipping_state' => $validated['state'],
            'shipping_zip' => $validated['zip'],
            'shipping_locality' => $validated['locality'],
            'shipping_landmark' => $validated['landmark'] ?? null,
        ]);

        // Optionally, create an Order model for historical orders

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}
