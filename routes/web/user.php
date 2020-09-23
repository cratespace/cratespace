<?php

use Illuminate\Support\Facades\Route;

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
        'Auth\ResetPasswordController@update'
    )->name('users.password');

    /*
     * Other Browser Sessions Invalidation Route.
     */
    Route::delete(
        '/user/other-browser-sessions',
        'Auth\OtherBrowserSessionsController@destroy'
    )->name('other-browser-sessions.destroy');

    /*
     * User Profile Photo Controller.
     */
    Route::delete(
        '/user/profile-photo',
        'Auth\ProfilePhotoController@destroy'
    )->name('current-user-photo.destroy');
});
