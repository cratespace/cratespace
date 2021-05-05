<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:sentinel', 'verified'],
], function () {
});
