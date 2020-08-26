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
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        return ($user->hasRole('support-agent') &&
            $user->is($ticket->agent)) ||
            $user->hasRole('admin');
    }
}
