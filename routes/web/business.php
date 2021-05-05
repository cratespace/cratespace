<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\InviteBusinessController;

Route::group([
    'middleware' => ['auth:sentinel', 'auth.business', 'verified'],
], function (): void {
    Route::get('/home', fn () => Inertia::render('Business/Home'))->name('home');

    Route::resource('spaces', SpaceController::class);
});

Route::get('/businesses/invitations/{invitation}', [InviteBusinessController::class, 'update'])
    ->middleware('signed')
    ->name('invitations.accept');
