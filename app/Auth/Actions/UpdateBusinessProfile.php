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
        $business = $user->business;

        $this->verifyEmail($user, $user->email);

        $business->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'street' => $data['street'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'postcode' => $data['postcode'],
        ]);
    }
}
