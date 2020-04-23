<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;

class NotifySubscribers
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $event->getReply()->thread->subscriptions
            ->where('user_id', '!=', $event->getReply()->user_id)
            ->each
            ->notify($event->getReply());
    }
}
