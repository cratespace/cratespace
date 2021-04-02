<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function updated(User $user)
    {
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function deleted(User $user)
    {
    }
}
