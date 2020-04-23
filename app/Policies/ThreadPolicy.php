<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Thread $thread
     *
     * @return bool
     */
    public function view(User $user, Thread $thread)
    {
        return $user->is($thread->user) || $user->isType(['admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Thread $thread
     *
     * @return bool
     */
    public function delete(User $user, Thread $thread)
    {
        return $user->is($thread->user) || $user->isType(['admin']);
    }
}
