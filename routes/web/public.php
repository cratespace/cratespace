<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
 * Landing Page & Spaces Listing Page...
 */
Route::get('/', 'SpacesListingController');

/*
 * Place Order for Space Route...
 */
Route::post('/spaces/{space}/orders', 'SpaceOrderController@store')
    ->name('spaces.orders');

/*
 * Checkout Page...
 */
Route::get('/spaces/{space}/checkout', 'CheckoutController@show')
    ->name('checkout');

/*
 * Order Completion Confirmation Route...
 */
Route::get('/thank-you', function () {
    return view('public.commons.thank-you');
})->name('thank-you');
