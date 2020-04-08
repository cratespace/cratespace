<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{
    use Queueable;

    /**
     * The thread that was updated.
     *
     * @var \App\Models\Thread
     */
    protected $thread;

    /**
     * The new reply.
     *
     * @var \App\Models\Reply
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Thread $thread
     * @param \App\Models\Reply  $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->user->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path()
        ];
    }
}
