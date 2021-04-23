<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\SpaceController;
use App\Http\Controllers\Business\InviteBusinessController;

Route::group([
    'middleware' => 'auth.business',
], function (): void {
    Route::resource('spaces', SpaceController::class);
});

Route::group([
    'middleware' => 'signed',
], function (): void {
    Route::get('/businesses/{invitation}', [InviteBusinessController::class, 'update'])->name('invitations.accept');
});
