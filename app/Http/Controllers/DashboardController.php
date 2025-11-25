<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->paginate(10);

        return view('dashboard.orders', compact('orders'));
    }
}
