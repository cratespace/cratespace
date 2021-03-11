<?php

namespace App\Actions\Business;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;

class CreateNewBusiness implements CreatesNewUsers
{
    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data): User
    {
        $data['user']->business()->create([
            'name' => $data['business'],
            'credit' => 0.00,
        ]);

        return $data['user']->fresh();
    }
}
