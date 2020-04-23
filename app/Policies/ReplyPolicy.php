<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Reply $reply
     *
<<<<<<< HEAD
     * @return bool
=======
     * @return mixed
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     */
    public function update(User $user, Reply $reply)
    {
        return $user->is($reply->user) || $user->isType(['admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Reply $reply
     *
<<<<<<< HEAD
     * @return bool
=======
     * @return mixed
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->is($reply->user) || $user->isType(['admin']);
    }
}
