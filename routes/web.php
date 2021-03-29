<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\InviteBusinessController;
use App\Http\Controllers\Auth\UpdateUserAddressInformationController;

Route::get('/', function (Request $request) {
    return Inertia::render('Welcome/Show');
})->name('welcome');

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::put('/user/address', [UpdateUserAddressInformationController::class, '__invoke'])->name('user.address');

    Route::group([
        'middleware' => ['business'],
    ], function (): void {
        Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');
        Route::get('/businesses', [BusinessController::class, 'create'])->name('business.create');
        Route::post('/businesses', [BusinessController::class, 'store'])->name('business.store');
        Route::post('/businesses/invite/{user}', [InviteBusinessController::class, '__invoke'])->name('business.invite');

        Route::resource('spaces', SpaceController::class);
    });
});
