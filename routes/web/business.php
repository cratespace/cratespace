<?php

use Illuminate\Support\Facades\Route;

/*
 * Authenticated Business Customer Routes...
 */
Route::group([
    'middleware' => ['auth', 'verified'],
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
     * Space Resource Routes...
     */
    Route::resource('/spaces', 'Business\SpaceController');
});
