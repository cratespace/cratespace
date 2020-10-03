<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Contracts\Auth\UpdatesUserProfile;
use App\Auth\Actions\Traits\HasEmailVerification;

class UpdateBusinessProfile implements UpdatesUserProfile
{
    use HasEmailVerification;

    /**
     * Validate and update the given user's profile information.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function update(User $user, array $data): void
    {
        $this->verifyEmail($user, $user->email);

        $user->business->update($data);
    }
}
