<?php

declare(strict_types=1);

Route::group([
    'prefix' => 'support',
], function (): void {
    /*
     * Support Threads Route...
     */
    Route::get('/threads', 'SupportThreadConroller@index')->name('support.threads.index');

    /*
     * Support Thread Route...
     */
    Route::get('/threads/{channel}/{thread}', 'SupportThreadConroller@show')->name('support.threads.show');
});
