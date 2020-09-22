<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
        'Auth\TwoFactorAuthenticationController@store'
    );

    Route::delete(
        '/two-factor-authentication',
        'Auth\TwoFactorAuthenticationController@destroy'
    );

    Route::get(
        '/two-factor-qr-code',
        'Auth\TwoFactorAuthenticationController@show'
    );

    Route::get(
        '/two-factor-recovery-codes',
        'Auth\RecoveryCodeController@index'
    );

    Route::post(
        '/two-factor-recovery-codes',
        'Auth\RecoveryCodeController@store'
    );
});
