<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Ticket instance.
     *
     * @var \App\Models\Ticket
     */
    public $ticket;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@cratespace.biz', 'Cratespace Support')
            ->to($this->ticket->email, $this->ticket->name)
            ->subject('New Support Ticket Created')
            ->markdown(
                'emails.support.tickets.created',
                ['ticket' => $this->ticket]
            );
    }
}
