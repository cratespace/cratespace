<?php

namespace App\Auth\Actions\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

trait HasEmailVerification
{
    /**
     * Check if the user is required to verify their email.
     *
     * @param \App\Models\User $user
     * @param string           $email
     *
     * @return void
     */
    public function verifyEmail(User $user, string $email): void
    {
        if ($email !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
    }
}
