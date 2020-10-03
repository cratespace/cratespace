<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function (): void {
    /*
     * User Account/Profile Resource Route...
     */
    Route::resource('/users', 'Auth\ProfileController', [
        'only' => ['edit', 'update', 'destroy'],
    ]);

    /*
     * User Business Resource Route...
     */
    Route::put(
        '/users/{user}/business',
        'Auth\BusinessProfileController@update'
    )->name('users.business');

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
