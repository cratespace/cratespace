<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BusinessController;

Route::get('/', fn () => Inertia::render('Marketing/Welcome'))->name('welcome');

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');

    Route::put('/user/business', [BusinessController::class, '__invoke'])->name('user.business');
});
