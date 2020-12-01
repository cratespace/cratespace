<?php

namespace App\Auth\Actions;

use App\Contracts\Auth\UpdatesUserProfiles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UpdateUserProfile implements UpdatesUserProfiles
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
            $user->updateProfilePhoto($data['photo']);
        }

        if ($data['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $data);
        } else {
            $user->forceFill([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     *
     * @return void
     */
    protected function updateVerifiedUser(Authenticatable $user, array $data): void
    {
        $user->forceFill([
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
