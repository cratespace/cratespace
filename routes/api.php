<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrentUserController;

Route::middleware('auth:sanctum')->get('/user/{attribute?}', [CurrentUserController::class, '__invoke']);
