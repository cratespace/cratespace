<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface UpdatesUserPasswords
{
    /**
     * Validate and update the user's password.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function update(User $user, array $data): void;
}
