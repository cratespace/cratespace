<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Contracts\Actions\UpdatesUserProfiles;

class UpdateUserProfile implements UpdatesUserProfiles
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
        $user->hasRole('Customer')
            ? $this->updateCustomerProfile($user, $data)
            : $this->updateBusinessProfile($user, $data);
    }

    /**
     * Update business user details.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function updateBusinessProfile(User $user, array $data): void
    {
        $user->profile->update([
            'name' => $data['business'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'registration_number' => $data['registration_number'],
            'business_profile' => [
                'name' => $data['business'],
                'mcc' => $data['mcc'],
                'support_phone' => $data['phone'],
                'support_email' => $data['email'],
                'url' => $data['url'],
            ],
        ]);
    }

    /**
     * Update customer profile details.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function updateCustomerProfile(User $user, array $data): void
    {
        $user->asStripeCustomer()->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $user->address->details(),
        ]);
    }
}
