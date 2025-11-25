<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveStream;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            'pinned_message' => $stream ? $stream->pinned_message : null,
            'is_banned' => $user ? $user->is_banned : false,
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
