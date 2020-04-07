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
        ->name('support.threads.create')
        ->middleware('auth');

    /*
     * Create New Thread Route...
     */
    Route::post('/threads', 'SupportThreadConroller@store')
        ->name('support.threads.store')
        ->middleware('auth');

    /*
     * Thread Search...
     */
    Route::get('/threads/search', 'SearchController@threads')
        ->name('support.threads.search');

    /*
     * Support Threads With Channel Route...
     */
    Route::get('/threads/{channel}', 'SupportThreadConroller@index');

    /*
     * Support Thread Route...
     */
    Route::get('/threads/{channel}/{thread}', 'SupportThreadConroller@show')
        ->name('support.threads.show')
        ->middleware('auth');

    /*
     * Support Thread Update Route...
     */
    Route::put('/threads/{channel}/{thread}', 'SupportThreadConroller@update')
        ->name('support.threads.update')
        ->middleware('auth');

    /*
     * Support Thread Delete Route...
     */
    Route::delete(
        '/threads/{channel}/{thread}',
        'SupportThreadConroller@destroy'
    )->name('support.threads.destroy')
    ->middleware('auth');

    /*
     * Reply Favorite Route...
     */
    Route::post('/replies/{reply}/favorites', 'FavoritesController@store')
        ->middleware('auth');

    /*
     * Reply Unfavorite Route...
     */
    Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')
        ->middleware('auth');

    /*
     * Thread Replies Route...
     */
    Route::get(
        '/threads/{channel}/{thread}/replies',
        'ReplyController@index'
    )->name('support.threads.replies.index')
    ->middleware('auth');

    /*
     * Create New Thread Reply Route...
     */
    Route::post(
        '/threads/{channel}/{thread}/replies',
        'ReplyController@store'
    )->name('support.threads.replies.store')
    ->middleware('auth');

    /*
     * Update Reply Route...
     */
    Route::put('/replies/{reply}', 'ReplyController@update')
        ->name('support.replies.update')
        ->middleware('auth');

    /*
     * Delete Reply Route...
     */
    Route::delete('/replies/{reply}', 'ReplyController@destroy')
        ->name('support.replies.destroy')
        ->middleware('auth');

    /*
     * Subscribe to Thread Route...
     */
    Route::post(
        '/threads/{channel}/{thread}/subscriptions',
        'SupportThreadSubscriptionsController@store'
    )->middleware('auth');

    /*
     * Unsubscribe from Thread Route...
     */
    Route::delete(
        '/threads/{channel}/{thread}/subscriptions',
        'SupportThreadSubscriptionsController@destroy'
    )->middleware('auth');

    /*
     * Lock Thread Route...
     */
    Route::post(
        '/threads/{channel}/{thread}/lock',
        'LockedThreadsController@store'
    )->name('support.threads.lock')->middleware('admin');

    /*
     * Unlock Thread Route...
     */
    Route::delete(
        '/threads/{channel}/{thread}/unlock',
        'LockedThreadsController@destroy'
    )->name('support.threads.unlock')->middleware('admin');
});
