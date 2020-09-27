<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Contracts\Auth\UpdatesUserProfile;
use App\Auth\Actions\Traits\HasEmailVerification;

class UpdateUserProfile implements UpdatesUserProfile
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
        $this->verifyEmail($user, $data['email']);

        if (isset($data['photo'])) {
            $user->updateProfilePhoto($data['photo']);
        }

        $user->update($data);
    }
}
