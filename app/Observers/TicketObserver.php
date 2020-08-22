<?php

namespace App\Observers;

use Exception;
use App\Models\User;
use App\Models\Ticket;
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
        try {
            if (is_null($ticket->agent_id)) {
                $this->generateHashCode($ticket);

                $this->assignToAgent($ticket);
            }
        } catch (Exception $e) {
            $ticket->status = 'Pending';
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
