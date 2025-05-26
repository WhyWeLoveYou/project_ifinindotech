<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', OrdersController::class);
Route::resource('users', UserController::class);
Route::resource('orders', OrdersController::class);
Route::get('/orders/print/pdf', [OrdersController::class, 'print_to_pdf'])->name('orders.print_pdf');
