<?php

namespace App\Exceptions;

use Exception;
use App\Models\User;

class CustomerAlreadyCreated extends Exception
{
    /**
     * Create a new CustomerAlreadyCreated instance.
     *
     * @param \App\Models\User $user
     *
     * @return \App\Exceptions\CustomerAlreadyCreated
     */
    public static function exists(User $user): CustomerAlreadyCreated
    {
        return new static(
            "User is already a Stripe customer with ID {$user->customer->stripe_id}."
        );
    }
}
