<?php

namespace App\Person;

use App\Models\User;
use App\Models\Business as BusinessModel;
use App\Contracts\Responsibility;

class Business implements Responsibility
{
    /**
     * Handle responsibility.
     *
     * @param  \App\Models\User   $user
     * @param  array  $data
     * @return App\Models\User
     */
    public function handle(User $person, array $data)
    {
        BusinessModel::create([
            'user_id' => $person->id,
            'name' => $data['business'],
            'slug' => $data['business'],
        ]);

        return $person;
    }
}
