<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\GamificationService;

class PaymentController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

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
        // Simulate Payment Processing Delay
        sleep(2);

        // Create Order
        $order = DB::transaction(function () {
            $cart = session()->get('cart');
            if (!$cart)
                return null;

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id() ?? 1, // Fallback for testing
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => 'credit_card_simulated'
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

            return $order;
        });

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        session()->forget('cart');

        // Award points
        $this->gamificationService->addPoints(Auth::user(), 100, 'purchase');

        return redirect()->route('payment.success')->with('order_id', $order->id);
    }

    public function success()
    {
        return view('payment.success');
    }
}
