<?php

namespace App\Person;

use App\Models\User;
use App\Contracts\Responsibility;

class Account implements Responsibility
{
    /**
     * Perform create responsibility.
     *
     * @param  \App\Models\User   $user
     * @param  array  $data
     * @return App\Models\User
     */
    public function create(User $person, array $data)
    {
        // AccountModel::create([
        //     'user_id' => $person->id
        // ]);

        return $person;
    }
}
