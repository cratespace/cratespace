<?php

declare(strict_types=1);

Route::group([
    'middleware' => 'guest',
], function (): void {
    /*
     * Contact Page...
     */
    Route::get('/contact', function () {
        return view('contact');
    })->name('messages.create');

    /*
     * Client Message Route...
     */
    Route::post('/contact', 'MessageController')->name('messages.store');

    /*
     * Checkout Routes...
     */
    Route::group([
        'prefix' => 'checkout',
    ], function (): void {
        /*
         * Checkout Page...
         */
        Route::get('/', 'CheckoutController@show')->name('checkout');

        /*
         * Checkout Page...
         */
        Route::get('/', 'CheckoutController@show')->name('checkout');

        /*
         * Purchase Route...
         */
        Route::post('/{space}', 'CheckoutController@store')
            ->name('checkout.store');

        /*
         * Cancel Purchase Route...
         */
        Route::get('/destroy', 'CheckoutController@destroy')
            ->name('checkout.destroy');
    });

    /*
     * Listings Page...
     */
    Route::get('/', 'ListingsController')->name('listings');

    /*
     * Place Order Route...
     */
    Route::post('/orders', 'OrderController@store')->name('orders.store');

    /*
     * Public Pages...
     */
    Route::get('/{page}', 'PublicPageController');
});
