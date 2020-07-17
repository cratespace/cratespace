<?php

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
