<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
<<<<<<< HEAD
=======
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification
{
    use Queueable;

    /**
     * @var \App\Reply
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param \App\Reply $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
<<<<<<< HEAD
     * @param mixed $notifiable
     *
=======
     * @param  mixed $notifiable
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
<<<<<<< HEAD
     * @param mixed $notifiable
     *
=======
     * @param  mixed $notifiable
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->reply->user->name . ' mentioned you in ' . $this->reply->thread->title,
<<<<<<< HEAD
            'link' => $this->reply->path(),
=======
            'link' => $this->reply->path()
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
        ];
    }
}
