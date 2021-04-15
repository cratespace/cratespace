<?php

namespace App\Services\Stripe;

use App\Models\User;
use App\Models\Customer as NativeCustomer;

class Customer extends Resource
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'customers';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = [
        'id',
        'name',
        'email',
        'phone',
        'description',
        'metadata',
        'payment_method',
        'address',
    ];

    /**
     * Get the native user ID of the customer.
     *
     * @param string $id
     *
     * @return \App\Models\User
     */
    public static function native(string $id): User
    {
        return NativeCustomer::where('stripe_id', $id)
            ->firstOrFail()
            ->account();
    }
}
