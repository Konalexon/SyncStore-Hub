<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\LiveStream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'users' => User::where('role', 'user')->count(),
            'orders' => DB::table('orders')->count(),
            'revenue' => DB::table('orders')->sum('total_amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
        ]);

        // Magic Price Generation
        if (empty($data['price'])) {
            $basePrice = match ($data['category']) {
                'Electronics' => 499.00,
                'Fashion' => 49.99,
                'Home & Living' => 29.99,
                'Sports' => 89.99,
                default => 19.99,
            };

            if (str_contains(strtolower($data['name']), 'pro'))
                $basePrice += 200;
            if (str_contains(strtolower($data['name']), 'max'))
                $basePrice += 100;
            if (str_contains(strtolower($data['name']), 'premium'))
                $basePrice *= 1.5;

            $data['price'] = round($basePrice, 2);
        }

        // Magic Description Generation
        if (empty($data['description'])) {
            $adjectives = ['Amazing', 'Incredible', 'High-quality', 'Premium', 'Essential'];
            $adj = $adjectives[array_rand($adjectives)];
            $data['description'] = "$adj {$data['name']} from our {$data['category']} collection. Designed for those who appreciate quality and style. Limited stock available!";
        }

        // Magic Image Selection
        if (empty($data['image'])) {
            $keywords = urlencode($data['category'] . ' ' . $data['name']);
            $data['image'] = "https://source.unsplash.com/featured/?{$keywords}";
        }

        Product::create($data);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function live()
    {
        $user = Auth::user();
        $stream = LiveStream::where('user_id', $user->id)->first();
        $products = Product::all();
        return view('admin.live', compact('stream', 'products'));
    }

    public function toggleLive(Request $request)
    {
        $user = Auth::user();
        $stream = LiveStream::firstOrCreate(
            ['user_id' => $user->id],
            ['title' => $user->name . "'s Stream"]
        );

        $stream->update([
            'is_active' => !$stream->is_active,
            'product_id' => $request->product_id,
        ]);

        return redirect()->back()->with('success', 'Live stream status updated!');
    }
}
