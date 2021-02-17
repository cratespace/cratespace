<?php

namespace App\Actions\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Cratespace\Sentinel\Contracts\Actions\UpdatesUserProfiles;

class UpdateBusinessInformation implements UpdatesUserProfiles
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     *
     * @return void
     */
    public function update(Authenticatable $user, array $data): void
    {
        if (isset($data['photo'])) {
            $user->business()->updateProfilePhoto($data['photo']);
        }

        $user->business()->update($data);
    }
}
