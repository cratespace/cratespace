<?php

use Illuminate\Support\Facades\Route;

/*
 * Landing Page Route...
 */
Route::get('/', fn () => 'Hello');

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
