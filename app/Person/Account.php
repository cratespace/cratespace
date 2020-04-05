<?php

namespace App\Person;

use App\Contracts\Responsibility;
use App\Models\Account as AccountModel;
use App\Models\User;

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
    public function handle(User $person, array $data)
    {
        AccountModel::create([
            'user_id' => $person->id,
            'bank' => $data['business'],
            'credit' => 0,
        ]);

        return $person;
    }
}
