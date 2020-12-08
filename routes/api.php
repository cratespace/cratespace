<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrentUserController;

Route::middleware('api')->get('/user/{attribute?}', [CurrentUserController::class, '__invoke']);
