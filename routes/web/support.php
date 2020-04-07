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
     * Create New Thread Route...
     */
    Route::get('/threads/create', 'SupportThreadConroller@create')
        ->name('support.threads.create');

    /*
     * Create New Thread Route...
     */
    Route::post('/threads', 'SupportThreadConroller@store')
        ->name('support.threads.store');

    /*
     * Support Threads With Channel Route...
     */
    Route::get('/threads/{channel}', 'SupportThreadConroller@index');

    /*
     * Support Thread Route...
     */
    Route::get('/threads/{channel}/{thread}', 'SupportThreadConroller@show')
        ->name('support.threads.show');

    Route::put('/threads/{channel}/{thread}', 'SupportThreadConroller@update')
        ->name('support.threads.update');

    Route::delete('/threads/{channel}/{thread}', 'SupportThreadConroller@destroy')
        ->name('support.threads.destroy');

    /*
     * Thread Replies Route...
     */
    Route::get(
        '/threads/{channel}/{thread}/replies',
        'ReplyController@index'
    )->name('support.threads.replies.index');
});
