<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RecoveryCodeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorQrCodeController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmedPasswordStatusController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Auth\TwoFactorAuthenticatedSessionController;

Route::group([
    'middleware' => 'guest',
], function (): void {
    Route::get('/signin', [AuthenticatedSessionController::class, 'create'])->name('signin');
    Route::middleware('auth.tfa')->post('/signin', [AuthenticatedSessionController::class, 'store']);
    Route::get('/tfa-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])->name('tfa.signin');
    Route::post('/tfa-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

    Route::get('/signup', [RegisteredUserController::class, 'create'])->name('signup');
    Route::post('/signup', [RegisteredUserController::class, 'store']);
});

Route::group([
    'middleware' => 'auth',
], function (): void {
    Route::post('/signout', [AuthenticatedSessionController::class, 'destroy'])->name('signout');

    Route::group([
        'prefix' => 'user',
    ], function (): void {
        Route::put('/password', [PasswordController::class, 'update'])->name('user-password.update');
        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::get('/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])->name('password.confirmation');
    });

    Route::group([
        'prefix' => 'user',
        'middleware' => config('auth.password_confirmation') ? ['auth', 'password.confirm'] : ['auth'],
    ], function (): void {
        Route::post('/tfa', [TwoFactorAuthenticationController::class, 'store']);
        Route::delete('/tfa', [TwoFactorAuthenticationController::class, 'destroy']);
        Route::get('/tfa-qr-code', [TwoFactorQrCodeController::class, 'show']);
        Route::get('/tfa-recovery-codes', [RecoveryCodeController::class, 'index']);
        Route::post('/tfa-recovery-codes', [RecoveryCodeController::class, 'store']);
    });
});
