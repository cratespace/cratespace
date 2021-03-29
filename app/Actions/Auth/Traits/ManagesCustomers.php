<?php

namespace App\Actions\Auth\Traits;

use App\Models\User;
use App\Services\Stripe\Customer;
use App\Services\Stripe\Resource;
use App\Exceptions\InvalidCustomerException;

trait ManagesCustomers
{
    /**
     * Get Stripe customer resource instance.
     *
     * @param \App\Models\User $user
     *
     * @return \App\Services\Stripe\Resource
     */
    public function getCustomer(User $user): Resource
    {
        $stripe_id = $user->customerId();

        if (! is_null($stripe_id)) {
            return new Customer($stripe_id);
        }

        throw new InvalidCustomerException("User [{$user->name}] is not a customer");
    }
}
