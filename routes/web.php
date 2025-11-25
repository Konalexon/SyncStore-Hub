<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\LiveStream;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CatalogController;

Route::get('/live/status', function () {
    $stream = LiveStream::first();
    return response()->json([
        'is_active' => $stream ? $stream->is_active : false,
        'product_id' => $stream ? $stream->product_id : null,
    ]);
});

Route::get('/catalog', [CatalogController::class, 'index']);

Route::get('/product/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('product', compact('product'));
});

Route::get('/live', function () {
    $stream = LiveStream::where('is_active', true)->first();
    $products = Product::take(5)->get(); // Featured products for sidebar
    return view('live', compact('products', 'stream'));
});

Route::get('/fix-data', function () {
    try {
        // 1. Create Admin
        User::updateOrCreate(
            ['email' => 'admin@syncstore.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'wallet_balance' => 1000.00,
                'email_verified_at' => now(),
            ]
        );

        // 2. Clear Products
        Product::truncate();

        return "Data fixed: Admin created, Products cleared.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});



// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->middleware('auth');

// Admin Panel
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::get('/products', [AdminController::class, 'products']);
    Route::post('/products', [AdminController::class, 'storeProduct']);
    Route::get('/live', [AdminController::class, 'live']);
    Route::post('/live', [AdminController::class, 'toggleLive']);
});

// Static Pages
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
