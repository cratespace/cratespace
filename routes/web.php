<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => Inertia::render('Welcome/Show'))->name('welcome');

/**
 * Admin Routes...
 */
require 'web/admin.php';

/**
 * Business Routes...
 */
require 'web/business.php';

/**
 * Customer Routes...
 */
require 'web/customer.php';
