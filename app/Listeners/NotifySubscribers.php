<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
<<<<<<< HEAD
=======
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

class NotifySubscribers
{
    /**
     * Handle the event.
     *
<<<<<<< HEAD
     * @param \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $event->getReply()->thread->subscriptions
            ->where('user_id', '!=', $event->getReply()->user_id)
            ->each
            ->notify($event->getReply());
=======
     * @param  \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $event->reply->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    }
}
