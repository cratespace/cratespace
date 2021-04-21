<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;

Route::group(['middleware' => ['guest']], function (): void {
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store']);

    Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'store']);

    Route::get('/two-factor-challenge', [TwoFactorAuthenticationController::class, 'create'])->name('two-factor.login');
    Route::post('/two-factor-challenge', [TwoFactorAuthenticationController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'create'])->name('password.reset');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('/reset-password', [PasswordResetController::class, 'store'])->name('password.update');
});

Route::group(['middleware' => ['auth']], function (): void {
    Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('logout');

    Route::group(['prefix' => 'user'], function (): void {
        Route::get('/confirm-password', [ConfirmPasswordController::class, 'show'])->name('password.confirm');
        Route::get('/confirmed-password-status', [ConfirmPasswordStatusController::class, '__invoke'])->name('password.confirmation');
        Route::post('/confirm-password', [ConfirmPasswordController::class, 'store']);

        Route::put('/password', [PasswordController::class, '__invoke'])->name('user-password.update');

        Route::get('/profile', [UserProfileController::class, 'show'])->name('user.show');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('user.update');
        Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('user.destroy');
        Route::delete('/profile-photo', [UserProfilePhotoController::class, '__invoke'])->name('current-user-photo.destroy');

        Route::group(['middleware' => 'password.confirm'], function (): void {
            Route::post('/two-factor-authentication', [TwoFactorAuthenticationStatusController::class, 'store']);
            Route::delete('/two-factor-authentication', [TwoFactorAuthenticationStatusController::class, 'destroy']);
            Route::get('/two-factor-qr-code', [TwoFactorQrCodeController::class, '__invoke']);
            Route::get('/two-factor-recovery-codes', [RecoveryCodeController::class, 'index']);
            Route::post('/two-factor-recovery-codes', [RecoveryCodeController::class, 'store']);
        });

        Route::delete('/other-browser-sessions', [OtherBrowserSessionsController::class, '__invoke'])->name('other-browser-sessions.destroy');
    });

    Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, '__invoke'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

Route::get('/csrf-cookie', [CsrfCookieController::class, '@show'])->name('api.auth');
