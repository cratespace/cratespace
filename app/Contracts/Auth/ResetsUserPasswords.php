<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \App\Models\User $user
     * @param string           $password
     *
     * @return void
     */
    public function reset(User $user, string $password): void;
}
