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

use App\Http\Controllers\LiveController;

Route::get('/live', [LiveController::class, 'index']);
Route::get('/live/status', [LiveController::class, 'status']);

// Admin Chat Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/live/pin', [LiveController::class, 'pinMessage']);
    Route::post('/live/ban', [LiveController::class, 'banUser']);
    Route::post('/live/unban', [LiveController::class, 'unbanUser']);
});

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Payment Routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::get('/catalog', [CatalogController::class, 'index']);

Route::get('/product/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('product', compact('product'));
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
Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->middleware('auth')->name('dashboard.orders');
Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->middleware('auth')->name('dashboard.settings');
Route::post('/dashboard/settings', [DashboardController::class, 'updateSettings'])->middleware('auth')->name('dashboard.settings.update');

use App\Http\Controllers\WishlistController;
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth')->name('wishlist.index');
Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->middleware('auth')->name('wishlist.toggle');

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
