<?php

namespace App\Actions\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Cratespace\Sentinel\Contracts\Actions\UpdatesUserProfiles;

class UpdateUserAccount implements UpdatesUserProfiles
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

        if ($data['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateInformation($user, $data, true);

            $user->sendEmailVerificationNotification();
        } else {
            $this->updateInformation($user, $data, false);
        }
    }

    /**
     * Update the given user's profile information.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $data
     * @param bool                                       $verified
     *
     * @return void
     */
    protected function updateInformation(Authenticatable $user, array $data, bool $verified = true): void
    {
        if ($this->hasAddressDetails($data)) {
            $user->forceFill(['address' => [
                'line1' => $data['line1'],
                'line2' => $data['line2'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'postal_code' => $data['postal_code'],
            ]])->save();
        }

        $user->forceFill(array_merge([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
        ], $verified ? ['email_verified_at' => null] : []))->save();
    }

    /**
     * Determine if address details exists in the given array.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function hasAddressDetails(array $data): bool
    {
        $required = ['line1', 'line2', 'city', 'state', 'country', 'postal_code'];

        return count(array_intersect_key(array_flip($required), $data)) === count($required);
    }
}
