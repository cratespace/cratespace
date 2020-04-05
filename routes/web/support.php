<?php

declare(strict_types=1);

Route::group([
    'prefix' => 'support',
], function (): void {
    /*
     * Support Threads Route...
     */
    Route::get('/threads', 'SupportThreadConroller@index')
        ->name('support.threads.index');

    /*
     * Support Threads With Channel Route...
     */
    Route::get('/threads/{channel}', 'SupportThreadConroller@index');

    /*
     * Support Thread Route...
     */
    Route::get('/threads/{channel}/{thread}', 'SupportThreadConroller@show')
        ->name('support.threads.show');

    /*
     * Thread Replies Route...
     */
    Route::get(
        '/threads/{channel}/{thread}/replies',
        'ReplyController@index'
    )->name('support.threads.replies.index');
});
