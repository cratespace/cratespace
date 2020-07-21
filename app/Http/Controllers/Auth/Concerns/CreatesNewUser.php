<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Auth\User;

trait CreatesNewUser
{
    /**
     * Create new user account.
     *
     * @param array $data
     *
     * @return \App\Auth\User
     */
    protected function createNewUser(array $data): User
    {
        return (new User())->new($data);
    }
}
