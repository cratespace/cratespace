<?php

use Illuminate\Support\Facades\Route;

/*
 * Landing Page & Spaces Listing Page...
 */
Route::get('/', 'SpacesListingController');

/*
 * Privacy Page...
 */
Route::get('/privacy', 'GeneralPagesController@privacy');

/*
 * Terms & Conditions Page...
 */
Route::get('/terms-conditions', 'GeneralPagesController@terms');

/*
 * Place Order for Space Route...
 */
Route::post('/spaces/{space}/orders', 'SpaceOrderController')
    ->name('spaces.orders');

/*
 * Checkout Page...
 */
Route::get('/spaces/{space}/checkout', 'CheckoutController')
    ->name('checkout');

/*
 * Order Completion Confirmation Route...
 */
Route::get('/orders/{confirmationNumber}', 'OrderConfirmationController')
    ->name('orders.confirmation');
