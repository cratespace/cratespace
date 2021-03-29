<?php

namespace App\Actions\Auth\Traits;

use App\Services\Stripe\Customer;
use App\Services\Stripe\Resource;
use App\Exceptions\InvalidCustomerException;

trait ManagesCustomers
{
    /**
     * Get Stripe customer resource instance.
     *
     * @param \App\Models\User|string $user
     *
     * @return \App\Services\Stripe\Resource
     */
    public function getCustomer($user): Resource
    {
        $stripe_id = is_string($user) ? $user : $user->customerId();

        if (! is_null($stripe_id)) {
            return new Customer($stripe_id);
        }

        throw new InvalidCustomerException("User [{$user->name}] is not a customer");
    }
}
