<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\HomeController;
use App\Http\Controllers\Business\OrderController;

/*
 * Authenticated Business Customer Routes...
 */
Route::group([
    'middleware' => ['auth', 'verified'],
], function (): void {
    /*
     * Business Customer Dashboard Route...
     */
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
     * Order Resource Routes...
     */
    Route::resource('/orders', 'Business\OrderController', [
        'except' => ['create', 'store', 'edit'],
    ]);

    /*
     * Search Orders Route...
     */
    Route::get('/orders/search', [OrderController::class, '@index']);

    /*
     * Space Resource Routes...
     */
    Route::resource('/spaces', 'Business\SpaceController');
});
