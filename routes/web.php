<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'Hello');

require 'web/auth.php';
