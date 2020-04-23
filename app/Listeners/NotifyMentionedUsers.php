<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->getReply()->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->getReply()));
            });
    }
}
