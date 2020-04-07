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
     * @return mixed
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
     * @return mixed
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->is($reply->user) || $user->isType(['admin']);
    }
}
