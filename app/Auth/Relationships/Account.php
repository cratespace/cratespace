<?php

namespace App\Auth\Relationships;

use App\Models\User;
use App\Contracts\Auth\Responsibility;
use App\Models\Account as AccountModel;

class Account implements Responsibility
{
    /**
     * Handle responsibility.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return App\Models\User
     */
    public function handle(User $user, array $data): User
    {
        AccountModel::create([
            'user_id' => $user->id,
            'credit' => 0,
        ]);

        return $user;
    }
}
