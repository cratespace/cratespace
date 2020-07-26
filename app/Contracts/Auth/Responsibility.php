<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface Responsibility
{
    /**
     * Handle responsibility.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return App\Models\User
     */
    public function handle(User $user, array $data): User;
}
