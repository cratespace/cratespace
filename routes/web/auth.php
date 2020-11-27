<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DeleteUserController;

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/user/{user}', [DeleteUserController::class, 'destroy'])
        ->name('user.destroy');
});
