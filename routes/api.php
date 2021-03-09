<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Authenticatable;

Route::middleware('auth:api')
    ->get('/user', function (Request $request): Authenticatable {
        return $request->user();
    });
