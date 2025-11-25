<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Request $request, $productId)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Product removed from wishlist.';
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            $message = 'Product added to wishlist.';
            $status = 'added';
        }

        return redirect()->back()->with('success', $message);
    }
}
