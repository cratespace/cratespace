<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

/*
 * Landing Page Route...
 */
Route::get('/', function () {
    auth()->logout();

    return Inertia::render('Welcome/Index');
})->name('welcome');

/**
 * User Authentication Routes...
 */
require 'web/auth.php';

/**
 * Business User Routes...
 */
require 'web/business.php';

/**
 * Customer User Routes...
 */
require 'web/customer.php';

/**
 * Administrator User Routes...
 */
require 'web/admin.php';
