<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Contracts\Auth\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function reset(User $user, array $data): void
    {
    }
}
