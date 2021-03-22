<?php

namespace App\Services\Stripe;

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
}
