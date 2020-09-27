<?php

namespace App\Auth\Actions\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait UpdatesPassword
{
    /**
     * Update password field of given user.
     *
     * @param \App\Models\User $user
     * @param string           $password
     *
     * @return void
     */
    public function updatePassword(User $user, string $password): void
    {
        $user->forceFill(['password' => Hash::make($password)])->save();
    }
}
