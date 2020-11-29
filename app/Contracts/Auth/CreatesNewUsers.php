<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data): User;
}
