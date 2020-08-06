<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Auth\User;
use App\Models\User as UserModel;

trait CreatesNewUser
{
    /**
     * Create new user account.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    protected function createNewUser(array $data): UserModel
    {
        return (new User())->new($data);
    }
}
