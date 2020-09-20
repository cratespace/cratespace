<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Models\User;

trait CreatesNewUsers
{
    /**
     * Create new user account.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    protected function createNewUser(array $data): User
    {
    }
}
