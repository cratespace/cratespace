<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Space $space
     *
     * @return bool
     */
    public function manage(User $user, Space $space): bool
    {
        return $user->is($space->user);
    }

    /**
     * Determine whether the model has no other commitments.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Space     $space
     *
     * @return bool
     */
    public function purchase(?User $user, Space $space): bool
    {
        return is_null($space->order);
    }
}
