<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Display Cart
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    // Add Item to Cart
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Update Item Quantity
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);

                // Calculate new totals
                $total = 0;
                $quantity = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                    $quantity += $item['quantity'];
                }

                return response()->json([
                    'success' => true,
                    'total' => $total,
                    'cart_count' => $quantity,
                    'item_total' => $cart[$request->id]['price'] * $request->quantity
                ]);
            }
        }

        return response()->json(['success' => false], 400);
    }

    // Remove Item
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            // Calculate new totals
            $total = 0;
            $quantity = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
                $quantity += $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'total' => $total,
                'cart_count' => $quantity
            ]);
        }
    }

    // Checkout
    public function checkout()
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        return redirect()->route('payment.index');
    }
}

