<?php

namespace App\Policies;

use App\Models\User;
use App\Products\Line\Space;
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
        return $user->isAdmin() || $user->isBusiness();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User         $user
     * @param \App\Products\Line\Space $space
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

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User         $user
     * @param \App\Products\Line\Space $space
     *
     * @return mixed
     */
    public function destroy(User $user, Space $space)
    {
        if ($this->manage($user, $space)) {
            return ! $space->reserved();
        }

        return false;
    }
}
