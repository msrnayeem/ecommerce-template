<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::get('/categories', function () {
    return view('pages.categories');
})->name('categories');

Route::get('/product-details', function () {
    return view('pages.product-details');
})->name('products-details');

Route::get('/checkout', function () {
    return view('pages.checkout');
})->name('checkout');

Route::get('/policies', function () {
    return view('pages.policy');
})->name('policies');

Route::get('/conditions', function () {
    return view('pages.conditions');
})->name('conditions');