<?php

namespace App\Auth\Relationships;

use App\Models\User;
use Illuminate\Support\Str;
use App\Contracts\Auth\Responsibility;
use App\Models\Business as BusinessModel;

class Business implements Responsibility
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
        BusinessModel::create([
            'user_id' => $user->id,
            'name' => $data['business'],
            'slug' => Str::slug($data['business']),
        ]);

        return $user;
    }
}
