<?php

namespace App\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

interface UpdatesUserPasswords
{
    /**
     * Validate and update the user's password.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     *
     * @return void
     */
    public function update(Authenticatable $user, array $data): void;
}
