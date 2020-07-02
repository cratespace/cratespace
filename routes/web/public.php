<?php

declare(strict_types=1);

Route::group([
    // 'middleware' => 'guest',
], function (): void {
    /*
     * Landing Page...
     */
    Route::get('/', function () {
        auth()->logout();

        return 'Works!';
    });
});
