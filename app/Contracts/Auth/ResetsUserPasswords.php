<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function reset(User $user, array $data): void;
}
