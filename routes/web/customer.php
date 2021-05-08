<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function () {
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
});
