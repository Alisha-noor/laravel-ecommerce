<?php

namespace App\Http\Controllers;

use App\Models\Address;

use App\Models\OrderItem;

use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;

use Illuminate\Http\Request;

class UserController extends Controller
{
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
