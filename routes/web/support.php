<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
 * Customer/Client Support Routes...
 */
Route::group([
    'prefix' => 'support',
], function (): void {
    /*
     * Support Landing Page...
     */
    Route::get('/', 'Support\SupportPageController')->name('support');

    /*
     * Support Ticket Resource Routes...
     */
    Route::resource('/tickets', 'Support\TicketController', [
        'except' => ['edit'],
    ]);

    /*
     * Support Ticket Resource Routes...
     */
    Route::resource('/tickets/replies', 'Support\TicketReplyController', [
        'only' => ['update', 'destroy'],
    ]);

    /*
     * Create New Reply Routes...
     */
    Route::post(
        '/tickets/{ticket}/replies',
        'Support\TicketReplyController@store'
    )->name('replies.store');
});