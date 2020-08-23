<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketAssignedMail extends Mailable implements ShouldQueue
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
        return $this->from('management@cratespace.biz', 'Cratespace Management')
            ->to($this->ticket->agent->email, $this->ticket->agent->name)
            ->subject('New Support Ticket Assigned')
            ->markdown(
                'emails.support.tickets.assigned',
                ['ticket' => $this->ticket]
            );
    }
}
