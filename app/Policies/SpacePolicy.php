<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
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
        return $user->isAdmin() || $user->usBusiness();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Space $space
     *
     * @return mixed
     */
    public function manage(User $user, Space $space)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isBusiness()) {
            return $user->is($space->owner);
        }

        return false;
    }
}
