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
        if ($user->hasRole('Administrator')) {
            return true;
        }

        if ($user->hasRole('Business')) {
            return $user->is($space->user);
        }

        return false;
    }

    /**
     * Determine whether the user can purchase the product.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Space $space
     *
     * @return mixed
     */
    public function purchase(User $user, Space $space)
    {
        if ($user->role->can('purchase') || $user->role->can('*')) {
            return ! $space->reserved() && ! $space->expired();
        }

        return false;
    }
}
