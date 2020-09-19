<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;

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
