<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveStream;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LiveController extends Controller
{
    // Public: List all active streams or show the lobby
    public function index()
    {
        $activeStreams = LiveStream::where('is_active', true)->with('user')->get();

        // If only one stream is active, redirect to it (optional, but good UX)
        // For now, let's just pass them to the view.

        return view('live.index', compact('activeStreams'));
    }

    // Public: Watch a specific stream
    public function show($id)
    {
        $stream = LiveStream::with(['user', 'product'])->findOrFail($id);
        $products = Product::take(5)->get(); // Featured products
        return view('live.show', compact('stream', 'products'));
    }

    // API: Get status of a specific stream (for polling)
    public function status(Request $request)
    {
        $streamId = $request->query('id');

        if ($streamId) {
            $stream = LiveStream::find($streamId);
        } else {
            // Fallback for legacy calls: get first active or just first
            $stream = LiveStream::where('is_active', true)->first() ?? LiveStream::first();
        }

        $user = Auth::user();

        return response()->json([
            'is_active' => $stream ? $stream->is_active : false,
            'product_id' => $stream ? $stream->product_id : null,
            'product' => $stream && $stream->product ? $stream->product : null,
            'auction_end_time' => $stream ? $stream->auction_end_time : null,
            'pinned_message' => $stream ? $stream->pinned_message : null,
            'is_banned' => $user ? $user->is_banned : false,
            'host_name' => $stream && $stream->user ? $stream->user->name : 'System',
        ]);
    }

    // Host: Start their own stream
    public function startStream(Request $request)
    {
        $user = Auth::user();

        // Find or create stream for this user
        $stream = LiveStream::firstOrCreate(
            ['user_id' => $user->id],
            ['title' => $user->name . "'s Stream"]
        );

        $stream->update(['is_active' => true]);

        return response()->json(['success' => true, 'stream_id' => $stream->id]);
    }

    // Host: Stop their own stream
    public function stopStream(Request $request)
    {
        $user = Auth::user();
        $stream = LiveStream::where('user_id', $user->id)->first();

        if ($stream) {
            $stream->update(['is_active' => false]);
        }

        return response()->json(['success' => true]);
    }

    // Host: Start Auction on their stream
    public function startAuction(Request $request)
    {
        $user = Auth::user();
        $stream = LiveStream::where('user_id', $user->id)->first();

        if ($stream) {
            $stream->update([
                'product_id' => $request->product_id,
                'auction_end_time' => now()->addSeconds($request->duration)
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Stream not found']);
    }

    // User: Place Bid (on the stream they are watching)
    public function placeBid(Request $request)
    {
        $user = Auth::user();
        $streamId = $request->input('stream_id');

        // If no stream_id provided, try to find the first active one (legacy fallback)
        $stream = $streamId ? LiveStream::find($streamId) : LiveStream::where('is_active', true)->first();

        if (!$stream || !$stream->product) {
            return response()->json(['success' => false, 'message' => 'No active auction']);
        }

        $product = $stream->product;
        $currentPrice = $product->price;
        $newPrice = $currentPrice + 10;

        $product->update(['price' => $newPrice]);

        return response()->json([
            'success' => true,
            'new_price' => $newPrice,
            'user' => $user->name
        ]);
    }

    // Admin/Host: Pin Message
    public function pinMessage(Request $request)
    {
        $user = Auth::user();
        // Allow admin to pin on any stream, or host on their own
        if ($user->role === 'admin') {
            // For simplicity in this demo, admin pins on their own stream or the first one
            $stream = LiveStream::where('user_id', $user->id)->first() ?? LiveStream::first();
        } else {
            $stream = LiveStream::where('user_id', $user->id)->first();
        }

        if ($stream) {
            $stream->update(['pinned_message' => $request->message]);
        }
        return response()->json(['success' => true]);
    }

    // ... ban/unban logic remains similar (global user ban)
    public function banUser(Request $request)
    {
        $user = User::where('name', $request->username)->first();
        if ($user) {
            $user->update(['is_banned' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    public function unbanUser(Request $request)
    {
        $user = User::where('name', $request->username)->first();
        if ($user) {
            $user->update(['is_banned' => false]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }
}
