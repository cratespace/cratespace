<?php

declare(strict_types=1);

Route::group([
    'middleware' => ['auth', 'business'],
], function (): void {
    /*
     * Dashboard...
     */
    Route::get('/home', 'HomeController')->name('home');

    /*
     * Spaces Search...
     */
    Route::get('/spaces/search', 'SearchController@spaces')
        ->name('spaces.search');

    /*
     * Spaces Routes...
     */
    Route::resource('/spaces', 'SpaceController');

    /*
     * Orders Search...
     */
    Route::get('/orders/search', 'SearchController@orders')
        ->name('orders.search');

    /*
     * Orders Routes...
     */
    Route::resource('/orders', 'OrderController', [
        'except' => ['store', 'edit', 'create'],
    ]);
});
