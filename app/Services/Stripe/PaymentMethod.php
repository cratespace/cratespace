<?php

namespace App\Services\Stripe;

class PaymentMethod extends Resource
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'paymentMethods';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = [
        'type',
        'billing_details',
        'metadata',
        'card',
    ];
}
