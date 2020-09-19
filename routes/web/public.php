<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GeneralPagesController;

/*
 * Landing Page & Spaces Listing Page...
 */
Route::get('/', 'SpacesListingController');

/*
 * Privacy Page...
 */
Route::get('/privacy', [GeneralPagesController::class, 'privacy']);

/*
 * Terms & Conditions Page...
 */
Route::get('/terms-conditions', [GeneralPagesController::class, 'terms']);

/*
 * Place Order for Space Route...
 */
Route::post('/spaces/{space}/orders', 'SpaceOrderController')
    ->name('spaces.orders');

/*
 * Checkout Page...
 */
Route::get('/spaces/{space}/checkout', [CheckoutController::class, 'show'])
    ->name('checkout');

/*
 * Order Completion Confirmation Route...
 */
Route::get('/orders/{confirmationNumber}', 'OrderConfirmationController')
    ->name('orders.confirmation');
