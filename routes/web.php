<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Pembeli\CartController as PembeliCartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuRatingController;
use App\Http\Controllers\Pembeli\PaymentController; // new
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Home route that will redirect based on role
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Public menu routes - accessible to all
Route::get('/menu', [MenuController::class, 'publicIndex'])->name('menu.index');
Route::get('/menu/{menu}', [MenuController::class, 'publicShow'])->name('menu.show');

// Profile routes for QRIS management (penjual only)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/profile/qris/upload', [ProfileController::class, 'uploadQris'])
        ->middleware('role:penjual')
        ->name('profile.qris.upload');
        
    Route::delete('/profile/qris/delete', [ProfileController::class, 'deleteQris'])
        ->middleware('role:penjual')
        ->name('profile.qris.delete');
});

// Penjual routes
Route::middleware(['auth', 'verified', 'role:penjual'])->prefix('penjual')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [\App\Http\Controllers\Penjual\DashboardController::class, 'index'])->name('penjual.dashboard');
    Route::get('/dashboard/stats', [\App\Http\Controllers\Penjual\DashboardController::class, 'getStats'])->name('penjual.dashboard.stats');
    
    // Menu management
    Route::get('/menu', [MenuController::class, 'index'])->name('penjual.menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('penjual.menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('penjual.menu.store');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('penjual.menu.show');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('penjual.menu.edit');
    Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('penjual.menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('penjual.menu.destroy');
    
    // Order management
    Route::get('/orders', [OrderController::class, 'index'])->name('penjual.orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('penjual.orders.update-status');
    
    // Daftar Pesanan COD
    Route::get('/daftar-pesanan', [OrderController::class, 'daftarPesanan'])->name('penjual.daftar_pesanan');
});

// Pembeli routes
Route::middleware(['auth', 'verified', 'role:pembeli'])->prefix('pembeli')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $menus = \App\Models\Menu::where('stok', '>', 0)->latest()->get();
        return view('pembeli.dashboard', compact('menus'));
    })->name('pembeli.dashboard');

    // Menu routes
    Route::prefix('menu')->group(function() {
        Route::get('/', [MenuController::class, 'publicIndex'])->name('pembeli.menu.index');
        Route::get('/{menu}', [MenuController::class, 'publicShow'])->name('pembeli.menu.show');
    });

    // Cart management
    Route::prefix('cart')->group(function () {
        Route::get('/', [PembeliCartController::class, 'index'])->name('pembeli.cart.index');
        Route::post('/', [PembeliCartController::class, 'store'])->name('pembeli.cart.store');
        Route::put('/{id}', [PembeliCartController::class, 'update'])->name('pembeli.cart.update');
        Route::delete('/{id}', [PembeliCartController::class, 'destroy'])->name('pembeli.cart.destroy');
        Route::get('/count', [PembeliCartController::class, 'count'])->name('pembeli.cart.count');
    });
    
    // Order management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'userOrders'])->name('pembeli.orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('pembeli.orders.store');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('pembeli.orders.cancel');
    });
    
    // Checkout process
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('pembeli.checkout.process');

    // Payment page
    Route::get('/payment/{store?}', [PaymentController::class, 'show'])->name('pembeli.payment.show');
});

// Checkout and payment routes
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order/{id}/paid', [OrderController::class, 'markAsPaid'])->name('order.paid');

// Shared routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/menu/{menu}/rating', [MenuRatingController::class, 'store'])->name('menu.rating.store');
    Route::post('/menu/{menu}/favorite', [MenuRatingController::class, 'toggleFavorite'])->name('menu.favorite');
});

require __DIR__.'/auth.php';
