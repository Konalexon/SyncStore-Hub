<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by Category
        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        // Filter by Price
        if ($request->has('price_range')) {
            $query->where('price', '<=', $request->price_range);
        }

        $products = $query->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('catalog', compact('products', 'categories'));
    }
}
