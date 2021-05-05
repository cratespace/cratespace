<?php

use Inertia\Inertia;
use App\Queries\SpaceQuery;
use App\Filters\SpaceFilter;
use Illuminate\Support\Facades\Route;

Route::get('/', function (SpaceFilter $filters) {
    return Inertia::render('Welcome/Index', [
        'spaces' => app(SpaceQuery::class)
            ->listing($filters)
            ->paginate(),
    ]);
})->name('welcome');

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
