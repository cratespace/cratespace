<?php

namespace App\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use App\Contracts\Auth\UpdatesUserPasswords;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateUserPassword implements UpdatesUserPasswords
{
    /**
     * Validate and update the user's password.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     *
     * @return void
     */
    public function update(Authenticatable $user, array $data): void
    {
        $user->forceFill(['password' => Hash::make($data['password'])])->save();
    }
}
