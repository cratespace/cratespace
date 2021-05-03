<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\InviteBusinessController;

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function (): void {
    Route::post('/businesses/invitations/{user}', [InviteBusinessController::class, 'store'])->name('invitations.store');
    Route::get('/businesses', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/businesses', [BusinessController::class, 'store'])->name('business.store');
});
