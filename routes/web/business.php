<?php

use Illuminate\Support\Facades\Route;

/*
 * Authenticated Business Customer Routes...
 */
Route::group([
    'middleware' => 'auth',
], function (): void {
    /*
     * Business Customer Dashboard Route...
     */
    Route::get('/home', 'Business\HomeController@index')->name('home');

    /*
     * Space Resource Routes...
     */
    Route::resource('/spaces', 'Business\SpaceController');
});
