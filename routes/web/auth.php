<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::middleware(['guest'])
    ->name('two-factor.login')
    ->get(
        '/two-factor-challenge',
        'Auth\TwoFactorLoginController@showLoginChallenge'
    );

Route::middleware(['guest'])
    ->post(
        '/two-factor-challenge',
        'Auth\TwoFactorLoginController@login'
    );

// $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
//     ? ['auth', 'password.confirm']
//     : ['auth'];

// Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
//     ->middleware($twoFactorMiddleware);

// Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
//     ->middleware($twoFactorMiddleware);

// Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
//     ->middleware($twoFactorMiddleware);

// Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
//     ->middleware($twoFactorMiddleware);

// Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
//     ->middleware($twoFactorMiddleware);
