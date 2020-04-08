<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Lock the given thread.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     */
    public function store(string $channel, Thread $thread)
    {
        $thread->update(['locked' => true]);
    }

    /**
     * Unlock the given thread.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     */
    public function destroy(string $channel, Thread $thread)
    {
        $thread->update(['locked' => false]);
    }
}
