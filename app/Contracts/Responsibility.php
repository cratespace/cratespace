<?php

namespace App\Contracts;

use App\Models\User;

interface Responsibility
{
    /**
     * Perform create responsibility.
     *
     * @param  \App\Models\User   $user
     * @param  array  $data
     * @return App\Models\User
     */
    public function create(User $user, array $data);
}
