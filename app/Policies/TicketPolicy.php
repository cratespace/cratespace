<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('support-agent') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->is($ticket->user) || $this->ticketBelongsToAgent($user, $ticket);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $this->ticketBelongsToAgent($user, $ticket);
    }

    /**
     * Determine if the given ticket is handled by the given agent.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return bool
     */
    protected function ticketBelongsToAgent(User $user, Ticket $ticket): bool
    {
        return ($user->hasRole('support-agent') && $user->is($ticket->agent)) ||
            $user->hasRole('admin');
    }
}
