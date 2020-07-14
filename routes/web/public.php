<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    auth()->logout();

    return view('public.landing.welcome');
});
