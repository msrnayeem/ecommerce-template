<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/explore/{categorySlug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/buy/{productSku}', [ProductController::class, 'show'])->name('products.show');
Route::get('/buy/now/{sku}', [ProductController::class, 'buyNow'])->name('buy.now');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.cart');
Route::get('/checkout', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/submit', [OrderController::class, 'store'])->name('cart.submit');
Route::get('/success', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/{order_id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

Route::get('/policies', function () {
    return view('pages.policy');
})->name('policies');

Route::get('/conditions', function () {
    return view('pages.conditions');
})->name('conditions');