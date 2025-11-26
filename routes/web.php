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

// Live Stream Routes
Route::get('/live', [LiveController::class, 'index']);
Route::get('/live/status', [LiveController::class, 'status']);

// Chat Routes
use App\Http\Controllers\ChatController;

Route::middleware(['auth'])->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});

// Admin Live Control Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/live/start', [LiveController::class, 'startStream']);
    Route::post('/live/stop', [LiveController::class, 'stopStream']);
    Route::post('/live/auction/start', [LiveController::class, 'startAuction']);

    // Chat Moderation
    Route::post('/live/pin', [ChatController::class, 'pinMessage']);
    Route::post('/live/ban', [ChatController::class, 'banUser']);
    Route::post('/live/unban', [LiveController::class, 'unbanUser']);
});

// User Interaction Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/live/bid', [LiveController::class, 'placeBid']);
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
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/dashboard/address', [ProfileController::class, 'updateAddress'])->name('profile.address');
});

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


