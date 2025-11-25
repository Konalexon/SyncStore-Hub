<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class PaymentController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('payment.index', compact('total'));
    }

    public function process(Request $request)
    {
        // Simulate Payment Processing
        // In a real app, this would interact with Stripe/PayPal API

        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $userId = auth()->id() ?? 1; // Fallback to Admin for testing if not logged in

        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $total,
            'status' => 'completed' // Paid
        ]);

        // Create Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('payment.success')->with('success', 'Payment successful!');
    }

    public function success()
    {
        return view('payment.success');
    }
}
