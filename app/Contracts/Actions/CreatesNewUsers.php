<?php

namespace App\Contracts\Actions;

use App\Models\User;

interface CreatesNewUsers
{
    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \App\Model\User
     */
    public function create(array $data): User;
}
