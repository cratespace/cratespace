<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
 * Authenticated Business Customer Routes...
 */
Route::group([
    'middleware' => ['auth', 'verified', 'money'],
], function (): void {
    /*
     * Business Customer Dashboard Route...
     */
    Route::get('/home', 'Business\HomeController@index')->name('home');

    /*
     * Order Resource Routes...
     */
    Route::resource('/orders', 'Business\OrderController', [
        'except' => ['create', 'store', 'edit'],
    ]);

    /*
     * Search Orders Route...
     */
    Route::get('/orders/search', 'Business\OrderController@index');

    /*
     * Space Resource Routes...
     */
    Route::resource('/spaces', 'Business\SpaceController');
});
