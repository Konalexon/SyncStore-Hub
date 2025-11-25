<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveStream;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiveController extends Controller
{
    public function index()
    {
        $stream = LiveStream::where('is_active', true)->first();
        $products = Product::take(5)->get();
        return view('live', compact('products', 'stream'));
    }

    public function status()
    {
        $stream = LiveStream::first();
        $user = Auth::user();

        return response()->json([
            'is_active' => $stream ? $stream->is_active : false,
            'product_id' => $stream ? $stream->product_id : null,
            'product' => $stream && $stream->product ? $stream->product : null,
            'pinned_message' => $stream ? $stream->pinned_message : null,
            'is_banned' => $user ? $user->is_banned : false,
        ]);
    }

    public function startStream(Request $request)
    {
        $stream = LiveStream::first();
        if (!$stream) {
            $stream = LiveStream::create(['title' => 'Main Stream', 'is_active' => true]);
        } else {
            $stream->update(['is_active' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function stopStream(Request $request)
    {
        $stream = LiveStream::first();
        if ($stream) {
            $stream->update(['is_active' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function startAuction(Request $request)
    {
        $stream = LiveStream::first();
        if ($stream) {
            $stream->update([
                'product_id' => $request->product_id,
                // In a real app, we'd store auction end time etc.
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function placeBid(Request $request)
    {
        $user = Auth::user();
        $stream = LiveStream::first();

        if (!$stream || !$stream->product) {
            return response()->json(['success' => false, 'message' => 'No active auction']);
        }

        $product = $stream->product;
        $currentPrice = $product->price;
        $newPrice = $currentPrice + 10; // Fixed bid increment for now

        // Update product price (simplified auction logic)
        $product->update(['price' => $newPrice]);

        return response()->json([
            'success' => true,
            'new_price' => $newPrice,
            'user' => $user->name
        ]);
    }

    // Admin Methods
    public function pinMessage(Request $request)
    {
        $stream = LiveStream::first();
        if ($stream) {
            $stream->update(['pinned_message' => $request->message]);
        }
        return response()->json(['success' => true]);
    }

    public function banUser(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->update(['is_banned' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function unbanUser(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->update(['is_banned' => false]);
        }
        return response()->json(['success' => true]);
    }
}
