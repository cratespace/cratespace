<?php

use App\Features\AppFeatures;
use App\Features\AuthFeatures;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiTokenController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\CurrentUserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RecoveryCodeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorQrCodeController;
use App\Http\Controllers\Auth\UserProfilePhotoController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtherBrowserSessionsController;
use App\Http\Controllers\Auth\ConfirmedPasswordStatusController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\TwoFactorAuthenticatedSessionController;

Route::group([
    'middleware' => 'guest',
], function (): void {
    // Sign In Routes...
    if (AuthFeatures::signin()) {
        Route::get('/signin', [AuthenticatedSessionController::class, 'create'])->name('signin');
        Route::post('/signin', [AuthenticatedSessionController::class, 'store']);
        if (AuthFeatures::hasTwoFactorAuthentication()) {
            Route::get('/tfa-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])->name('tfa.signin');
            Route::post('/tfa-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);
        }
    }

    // Sign Up Routes...
    if (AuthFeatures::signin() && AuthFeatures::signup()) {
        Route::get('/signup', [RegisteredUserController::class, 'create'])->name('signup');
        Route::post('/signup', [RegisteredUserController::class, 'store']);
    }

    // Reset Password Routes...
    if (AuthFeatures::passwordReset()) {
        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    }
});

Route::group([
    'middleware' => 'auth',
], function (): void {
    // Sign Out Route...
    Route::post('/signout', [AuthenticatedSessionController::class, 'destroy'])->name('signout');

    // Email Verification Routes...
    if (AuthFeatures::emailVerification()) {
        Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['throttle:6,1'])
            ->name('verification.send');
    }

    Route::group([
        'prefix' => 'user',
    ], function (): void {
        // Update & Confirm Password Routes...
        Route::put('/password', [PasswordController::class, 'update'])->name('user-password.update');
        if (AuthFeatures::passwordConfirmation()) {
            Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
            Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
            Route::get('/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])->name('password.confirmation');
        }

        // Other Browser Sessions Route...
        if (AuthFeatures::otherBrowserSessions()) {
            Route::delete('/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])->name('other-browser-sessions.destroy');
        }

        // User Profile Routes...
        Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [CurrentUserController::class, 'destroy'])->name('user.destroy');

        // User Profile Picture...
        if (AppFeatures::hasProfilePhoto()) {
            Route::delete('/profile-photo', [UserProfilePhotoController::class, 'destroy'])->name('user-photo.destroy');
        }

        // API Token Routes...
        if (AppFeatures::hasApiToken()) {
            Route::get('/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            Route::post('/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
            Route::put('/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
            Route::delete('/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
        }
    });

    if (AuthFeatures::hasTwoFactorAuthentication()) {
        Route::group([
            'prefix' => 'user',
            'middleware' => AuthFeatures::hasPasswordConfirmation() ? ['auth', 'password.confirm'] : ['auth'],
        ], function (): void {
            // Two Factor Authentication Routes...
            Route::post('/tfa', [TwoFactorAuthenticationController::class, 'store']);
            Route::delete('/tfa', [TwoFactorAuthenticationController::class, 'destroy']);
            Route::get('/tfa-qr-code', [TwoFactorQrCodeController::class, 'show']);
            Route::get('/tfa-recovery-codes', [RecoveryCodeController::class, 'index']);
            Route::post('/tfa-recovery-codes', [RecoveryCodeController::class, 'store']);
        });
    }
});
