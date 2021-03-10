<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Auth\UserBusinessController;
use App\Http\Controllers\Public\OrderController as PublicOrderController;

Route::get('/', fn () => Inertia::render('Marketing/Welcome'))->name('welcome');

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');
    Route::put('/user/business', [UserBusinessController::class, '__invoke'])->name('user.business');
    Route::resource('/spaces', SpaceController::class);
    Route::post('/spaces/{space}/orders', [PublicOrderController::class, 'store'])->name('orders.create');
    Route::get('/orders/{order}', [PublicOrderController::class, 'show'])->name('orders.show');
});
