<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the space.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Space $space
     *
     * @return bool
     */
    public function manage(User $user, Space $space)
    {
        return $user->is($space->user) || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Space $space
     *
     * @return mixed
     */
    public function delete(User $user, Space $space)
    {
        return ($user->is($space->user) && !$space->hasOrder()) ||
            $user->hasRole('admin');
    }
}
