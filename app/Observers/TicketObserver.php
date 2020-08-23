<?php

namespace App\Observers;

use Exception;
use App\Models\User;
use App\Models\Ticket;
use App\Mail\NewTicketCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewTicketAssigned;
use App\Observers\Traits\GeneratesHashids;
use App\Exceptions\AgentNotAvailableException;

class TicketObserver
{
    use GeneratesHashids;

    /**
     * Handle the ticket "creating" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function creating(Ticket $ticket): void
    {
        $this->generateHashCode($ticket);

        try {
            if (is_null($ticket->agent_id)) {
                $this->assignToAgent($ticket);
            }
        } catch (Exception $e) {
            $ticket->status = 'Pending';
        }
    }

    /**
     * Handle the ticket "created" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function created(Ticket $ticket): void
    {
        Mail::to($ticket->email)->send(
            new NewTicketCreatedMail($ticket)
        );

        if (!is_null($ticket->agent_id)) {
            $ticket->agent->notify(new NewTicketAssigned($ticket));
        }
    }

    /**
     * Handle the ticket "updated" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function updated(Ticket $ticket): void
    {
        // Mail::send(new TicketStatusUpdatedEvent($ticket));
    }

    /**
     * Assign support ticket to free agent.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return bool
     */
    protected function assignToAgent(Ticket $ticket): bool
    {
        $supportAgents = User::all()
            ->filter(function ($user) {
                return $user->hasRole('support-agent') &&
                    $user->tickets->count() <= config('defaults.support-agents.max-tickets');
            });

        if (!$supportAgents->isEmpty()) {
            return $ticket->agent_id = $supportAgents->random()->id;
        }

        throw new AgentNotAvailableException();
    }
}
