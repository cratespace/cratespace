<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\SpaceController as CustomerSpaceController;

Route::get('/', [CustomerSpaceController::class, '__invoke'])->name('welcome');

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
