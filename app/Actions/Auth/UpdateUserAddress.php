<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Contracts\Actions\UpdatesUserProfiles;

class UpdateUserAddress implements UpdatesUserProfiles
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
        $user->forceFill([
            'address' => $address = [
                'line1' => $data['line1'],
                'line2' => $data['line2'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'postal_code' => $data['postal_code'],
            ],
        ])->save();

        if ($user->isCustomer()) {
            $user->asStripeCustomer()->update(['address' => $address]);
        }
    }
}
