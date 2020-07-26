<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

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
