<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataUserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\KabupatenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Home
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('post', [HomeController::class, 'dashboard'])->middleware(['auth', 'admin']);

// Rental
Route::get('rental', [ProductController::class, 'rental'])->middleware('auth')->name('rental');
Route::get('cart', [ProductController::class, 'cart'])->middleware('auth')->name('cart');

// Cart Operations
Route::post('/item/{id}', [ProductController::class, 'addToCart'])->name('additem.to.cart');

// Update and delete cart item routes
// Route::patch('/update-cart-item/{id}', [ProductController::class, 'updateCartItem'])->name('update.cart.item');
Route::post('/update-cart-item/{id}', [ProductController::class, 'updateCartItem'])->name('update.cart.item');

// Route::post('/update-multiple-cart-items', [ProductController::class, 'updateMultipleCartItems'])->name('update.multiple.cart.items');
Route::get('/payment', [OrderController::class, 'payment'])->middleware('auth')->name('payment');
Route::delete('/delete-cart-item/{id}', [ProductController::class, 'deleteCartItem'])->name('delete.cart.item');

// Checkout
// Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
// Route::get('/payment', [OrderController::class, 'payment'])->middleware('auth')->name('payment');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout')->middleware('auth');


// Your Orders
Route::get('/orders', [OrderController::class, 'orders'])->middleware('auth')->name('orders');
Route::put('/update-order-status/{orderId}', [OrderController::class, 'updateOrderStatus'])->name('update.order.status');
Route::delete('/orders/delete/{order}', [OrderController::class, 'destroy'])->middleware('auth');



// Return Order
Route::post('/return-order/{orderId}', [OrderController::class, 'transaction'])->name('return.order');
Route::put('/confirm-return/{orderId}', [OrderController::class, 'confirmReturn'])->name('confirm.return');


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-admin', [ProfileController::class, 'editAdmin'])->name('profile.editadmin');
    Route::patch('/profile-admin', [ProfileController::class, 'updateAdmin'])->name('profile.updateadmin');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin

//Dashboard

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'admin']);
// Route::get('/data-users', [DataUserController::class, 'index'])->middleware(['auth', 'admin']);
Route::resource('/data-user', \App\Http\Controllers\Admin\DataUserController::class);
Route::resource('/data-product', \App\Http\Controllers\Admin\DataProdukController::class);
Route::resource('/data-transaksi', \App\Http\Controllers\Admin\DataTransaksiController::class);
Route::get('/cetak-data-transaksi', [\App\Http\Controllers\Admin\DataTransaksiController::class, 'cetakTransaksi'])->name('cetak-data-transaksi');
Route::resource('/data-pengembalian', \App\Http\Controllers\Admin\DataPengembalianController::class);
// Route::get('/data-pengembalian/{id}', [\App\Http\Controllers\Admin\DataPengembalianController::class, 'show'])->name('data-pengembalian.show');
// Route::delete('/data-pengembalian/{id}', [\App\Http\Controllers\Admin\DataPengembalianController::class, 'destroy'])->name('data-pengembalian.destroy');
Route::get('/admin/returns', [DashboardController::class, 'returns'])->name('admin.returns');

// Authentication Routes...
require __DIR__ . '/auth.php';

// Registration Routes
Route::get('register', [RegisteredUserController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::post('register', [RegisteredUserController::class, 'store'])->middleware('guest');



Route::get('/get-kabupaten/{provinsiId}', [KabupatenController::class, 'getKabupatenByProvince']);
