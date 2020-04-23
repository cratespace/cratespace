<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
<<<<<<< HEAD
=======
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
<<<<<<< HEAD
     * @param \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->getReply()->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->getReply()));
=======
     * @param  \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
            });
    }
}
