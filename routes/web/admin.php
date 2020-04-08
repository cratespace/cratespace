<?php

declare(strict_types=1);

Route::group([
    'middleware' => ['auth', 'admin'],
], function (): void {
    /*
     * Admin Dashboard...
     */
    Route::get('/admin', 'Admin\HomeController')->name('admin');
});
