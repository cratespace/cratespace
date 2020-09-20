<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\OtherBrowserSessionsController;

Route::group(['middleware' => ['auth', 'verified']], function (): void {
    /*
     * User Account/Profile Resource Route...
     */
    Route::resource('/users', 'Auth\ProfileController');

    /*
     * User Password Reset Route.
     */
    Route::put(
        '/users/{user}/update/password',
        [ResetPasswordController::class, '@update']
    )->name('users.password');

    /*
     * Other Browser Sessions Invalidation Route.
     */
    Route::delete(
        '/user/other-browser-sessions',
        [OtherBrowserSessionsController::class, 'destroy']
    )->name('other-browser-sessions.destroy');

    /*
     * User Profile Photo Controller.
     */
    Route::delete(
        '/user/profile-photo',
        [ProfilePhotoController::class, 'destroy']
    )->name('current-user-photo.destroy');
});
