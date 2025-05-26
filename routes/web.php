<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::resource('users', UserController::class);
Route::resource('orders', OrdersController::class);
Route::get('/orders/print/pdf/{id}', [OrdersController::class, 'print_single_pdf'])->name('orders.print_pdf');
