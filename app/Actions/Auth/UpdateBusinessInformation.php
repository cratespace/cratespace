<?php

namespace App\Actions\Auth;

use App\Models\User;
use Cratespace\Sentinel\Contracts\Actions\UpdatesUserProfiles;

class UpdateBusinessInformation implements UpdatesUserProfiles
{
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
        if (isset($data['photo'])) {
            $user->business->updateProfilePhoto($data['photo']);
        }

        $user->business->update($data);
    }
}
