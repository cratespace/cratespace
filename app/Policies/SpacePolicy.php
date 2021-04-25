<?php

namespace App\Policies;

use App\Models\User;
use App\Products\Products\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User             $user
     * @param \App\Products\Products\Space $space
     *
     * @return mixed
     */
    public function manage(User $user, Space $space)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isBusiness() && $user->is($space->owner);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->usBusiness();
    }
}
