<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\InviteBusinessController;

Route::group([
    'middleware' => ['auth.business', 'auth:cratespace', 'verified'],
], function (): void {
    Route::resource('spaces', SpaceController::class);
});

Route::get('/businesses/invitations/{invitation}', [InviteBusinessController::class, 'update'])
    ->middleware('signed')
    ->name('invitations.accept');
