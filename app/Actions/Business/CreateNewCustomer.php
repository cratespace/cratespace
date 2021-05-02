<?php

namespace App\Actions\Business;

use App\Models\Customer;
use App\Exceptions\CustomerAlreadyCreated;
use App\Services\Stripe\Customer as StripeCustomer;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewResource;

class CreateNewCustomer implements CreatesNewResource
{
    /**
     * Create a new resource type.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return with($data['user'], function ($user) use ($data) {
            if ($user->isCustomer()) {
                throw CustomerAlreadyCreated::exists($user->customerId());
            }

            if ($this->stripeEnabled()) {
                $stripeProfile = StripeCustomer::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);
            }

            Customer::create([
                'user_id' => $user->id,
                'stripe_id' => isset($stripeProfile)
                    ? $stripeProfile->id
                    : null,
            ]);

            $user->assignRole('Customer');

            return $user;
        });
    }

    /**
     * Determine if Stripe services are enabled.
     *
     * @return bool
     */
    protected function stripeEnabled(): bool
    {
        return app()->isProduction() || config('billing.enabled');
    }
}
