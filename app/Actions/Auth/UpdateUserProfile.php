<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\Stripe\Customer;
use Illuminate\Contracts\Auth\Authenticatable;
use Cratespace\Sentinel\Contracts\Actions\UpdatesUserProfiles;

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
    protected function updateBusinessProfile(User $user, array $data): void
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
    protected function updateCustomerProfile(User $user, array $data): void
    {
        $customer = new Customer($user->customerId());

        $customer->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => (array) $user->address,
        ]);
    }
}
