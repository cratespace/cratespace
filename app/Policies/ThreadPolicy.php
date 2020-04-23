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
<<<<<<< HEAD
     * @return bool
=======
     * @return mixed
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
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
<<<<<<< HEAD
     * @return bool
=======
     * @return mixed
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     */
    public function delete(User $user, Thread $thread)
    {
        return $user->is($thread->user) || $user->isType(['admin']);
    }
}
