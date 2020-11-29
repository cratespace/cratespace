<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::group([
    'middleware' => 'guest',
], function (): void {
    Route::get('/signin', [AuthenticatedSessionController::class, 'create'])->name('signin');
    Route::post('/signin', [AuthenticatedSessionController::class, 'store']);

    Route::get('/signup', [RegisteredUserController::class, 'create'])->name('signup');
    Route::post('/signup', [RegisteredUserController::class, 'store']);
});

Route::group([
    'middleware' => 'auth',
], function (): void {
    Route::post('/signout', [AuthenticatedSessionController::class, 'destroy'])->name('signout');
});
