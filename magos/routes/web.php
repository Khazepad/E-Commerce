<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\InventoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Product routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});


Route::get('/choice', function () {
    return view('auth.choice');
})->name('choice');
// Logout route paadtog admin/login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
});
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/products', [App\Http\Controllers\ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/admin/products/create', [App\Http\Controllers\ProductController::class, 'adminCreate'])->name('admin.products.create');
    Route::post('/admin/products', [App\Http\Controllers\ProductController::class, 'adminStore'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'adminEdit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [App\Http\Controllers\ProductController::class, 'adminUpdate'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [App\Http\Controllers\ProductController::class, 'adminDestroy'])->name('admin.products.destroy');
    Route::get('/orders/report', [App\Http\Controllers\OrderController::class, 'report'])->name('admin.orders.report');
    Route::post('/admin/products/{product}/restock', [AdminProductController::class, 'restockProduct'])->name('admin.products.restock');
    Route::get('/admin/products/low-stock', [AdminProductController::class, 'checkLowStock'])->name('admin.products.low-stock');
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
    Route::put('/admin/inventory/{product}', [InventoryController::class, 'update'])->name('admin.inventory.update');
    Route::get('/admin/inventory/low-stock', [InventoryController::class, 'lowStockAlert'])->name('admin.inventory.low-stock');
    Route::post('/admin/inventory/{product}/restock', [InventoryController::class, 'restock'])->name('admin.inventory.restock');
    Route::post('/admin/products/{product}/discontinue', [ProductController::class, 'discontinue'])->name('admin.products.discontinue');
});


// mu direct sa admin dashboard
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth:admin');
// views/products/index 
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
// Cart routes para matawag ang views
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [CartController::class, 'placeOrder'])->name('place.order');
// Para makita ang receipt
Route::get('/order/receipt/{order}', [CartController::class, 'showReceipt'])->name('order.receipt');
// Order routes para sa user
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders')->middleware('auth');
    
});
// Order routes para sa admin
Route::middleware(['auth:admin', 'prevent-authenticated-user'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/report', [OrderController::class, 'report'])->name('admin.orders.report');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
// mu connect ni sya sa admin/orders para mag function
Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'adminIndex'])->name('admin.orders.index');
Route::get('/admin/orders/{order}', [App\Http\Controllers\OrderController::class, 'adminShow'])->name('admin.orders.show');
Route::get('/admin/orders/report', [App\Http\Controllers\OrderController::class, 'report'])->name('admin.orders.report');
Route::patch('/admin/orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

Route::get('/admin/low-stock-products', [AdminController::class, 'checkLowStock'])->name('admin.low-stock-products');
Route::post('/admin/restock/{product}', [AdminController::class, 'restockProduct'])->name('admin.restock');

Route::get('/payment/success', [CartController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [CartController::class, 'paymentCancel'])->name('payment.cancel');

Route::post('/apply-voucher', [CartController::class, 'applyVoucher'])->name('apply.voucher');

// Inventory routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
    Route::put('/admin/inventory/{product}', [InventoryController::class, 'update'])->name('admin.inventory.update');
    Route::get('/admin/inventory/low-stock', [InventoryController::class, 'lowStockAlert'])->name('admin.inventory.low-stock');
    Route::post('/admin/inventory/{product}/restock', [InventoryController::class, 'restock'])->name('admin.inventory.restock');
});

require __DIR__.'/auth.php';
// Sa discontinued products ni sya
Route::get('/admin/products/discontinued', [ProductController::class, 'discontinued'])->name('admin.products.discontinued');
Route::post('/admin/products/{product}/restore', [ProductController::class, 'restore'])->name('admin.products.restore');
