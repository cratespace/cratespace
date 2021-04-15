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

    /**
     * Attaches a PaymentMethod object to a Customer.
     *
     * @param \App\Services\Stripe\Customer $customer
     *
     * @return void
     */
    public function attach(Customer $customer): void
    {
        static::createService()->attach($this->id, [
            'customer' => $customer->id,
        ]);
    }

    /**
     * Detaches a PaymentMethod object from a Customer.
     *
     * @return void
     */
    public function detach(): void
    {
        static::createService()->detach($this->id);
    }
}
