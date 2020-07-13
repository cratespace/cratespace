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
    Route::get('/home', 'HomeController@index')->name('home');
});
