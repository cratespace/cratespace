<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use App\Mail\NewTicketAssignedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Ticket instance.
     *
     * @var \App\Models\Ticket
     */
    public $ticket;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    public function toMail($notifiable)
    {
        return (new NewTicketAssignedMail($this->ticket))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->ticket,
            'message' => 'A new support request ticket has been assigned to you.',
        ];
    }
}
