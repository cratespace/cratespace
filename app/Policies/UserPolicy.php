<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return bool
     */
    public function manage(User $user, User $model)
    {
        return $this->isOwner($user, $model) || $user->hasAbility('all');
    }

    /**
     * Determine if the user owns the given account.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return bool
     */
    protected function isOwner(User $user, User $model): bool
    {
        return $user->is($model) && $user->hasAbility('edit_user_settings');
    }
}
