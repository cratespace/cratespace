<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\InviteBusinessController;

Route::get('/', fn () => Inertia::render('Welcome/Show'))->name('welcome');

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');

    Route::get('/businesses', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/businesses', [BusinessController::class, 'store'])->name('business.store');
    Route::post('/businesses/invite/{user}', [InviteBusinessController::class, '__invoke'])->name('business.invite');

    Route::resource('spaces', SpaceController::class);
});
