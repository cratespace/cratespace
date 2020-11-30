<?php

namespace App\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

interface ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     *
     * @return void
     */
    public function reset(Authenticatable $user, array $data): void;
}
