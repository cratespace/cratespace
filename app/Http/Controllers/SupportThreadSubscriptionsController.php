<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class SupportThreadSubscriptionsController extends Controller
{
    /**
     * Store a new thread subscription.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     */
    public function store(string $channel, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Delete an existing thread subscription.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     */
    public function destroy(string $channel, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
