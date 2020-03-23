<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Models\User;
use App\Models\Company;
use App\Models\Business;

trait CreatesBusiness
{
    /**
     * Create a profile for the user.
     *
     * @param  \App\Models\User   $user
     * @param  array  $data
     * @return void
     */
    protected function createBusiness(User $user, array $data)
    {
        Business::create([
            'user_id' => $user->id,
            'name' => $data['business'],
            'slug' => $data['business'],
        ]);
    }
}
