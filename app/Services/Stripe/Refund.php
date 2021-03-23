<?php

namespace App\Services\Stripe;

class Refund extends Resource
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'refunds';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = [
        'amount',
        'payment_intent',
        'reason',
        'metadata',
    ];
}
