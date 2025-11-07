<?php

namespace App\Http\Controllers;

use App\Models\Address;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Storage;

use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\User as ModelsUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // UserController.php
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        return back()->with('success', 'Profile picture updated successfully!');
    }
    public function removeAvatar(Request $request)
    {
        $user = auth()->user();

        if ($user->avatar && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar); // file delete
        }

        $user->avatar = null; // database se hata do
        $user->save();

        return back()->with('success', 'Profile picture removed successfully.');
    }

    public function edit()
    {
        $user = auth()->user();              // ✅ define user first
        $addresses = $user->addresses ?? []; // safe if no addresses

        return view('usereditprofile', compact('user', 'addresses'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('userprofile')->with('success', 'Profile updated successfully!');
    }

    public function profile()
    {
        $user = auth()->user();

        // Assuming addresses table has a `user_id` foreign key
        $address = \App\Models\Address::where('user_id', $user->id)->first();

        return view('userprofile', compact('user', 'address'));
    }

    public function account_dashboard()
    {
        return view('users.dashboard');
    }



    public function account_orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.orders', compact('orders'));
    }
    public function account_order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('user.order-details', compact('order', 'orderItems', 'transaction'));
    }
    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses; // Assuming relation hai User -> Address
        return view('user.addresses', compact('addresses'));
    }
}
