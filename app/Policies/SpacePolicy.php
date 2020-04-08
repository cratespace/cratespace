<?php

namespace App\Policies;

use App\Models\Space;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the space.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Space  $space
     * @return bool
     */
    public function manage(User $user, Space $space)
    {
        return $user->is($space->user) || $user->isType(['admin']);
    }
}
