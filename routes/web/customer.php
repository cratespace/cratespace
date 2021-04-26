<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OrderController;

Route::group([
    'middleware' => [],
], function () {
    Route::get('/checkout/{product}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/checkout/{product}', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
