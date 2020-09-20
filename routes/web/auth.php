<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecoveryCodeController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;

Auth::routes(['verify' => true]);

Route::group([
    'middleware' => ['guest'],
], function (): void {
    Route::name('two-factor.login')
        ->get(
            '/two-factor-challenge',
            'Auth\TwoFactorLoginController@showLoginChallenge'
        );

    Route::post(
        '/two-factor-challenge',
        'Auth\TwoFactorLoginController@login'
    );
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'user',
], function (): void {
    Route::post(
        '/two-factor-authentication',
        [TwoFactorAuthenticationController::class, 'store']
    );

    Route::delete(
        '/two-factor-authentication',
        [TwoFactorAuthenticationController::class, 'destroy']
    );

    Route::get(
        '/two-factor-qr-code',
        [TwoFactorQrCodeController::class, 'show']
    );

    Route::get(
        '/two-factor-recovery-codes',
        [RecoveryCodeController::class, 'index']
    );

    Route::post(
        '/two-factor-recovery-codes',
        [RecoveryCodeController::class, 'store']
    );
});
