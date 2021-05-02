<?php

namespace App\Models\Concerns;

use App\Models\Customer;
use App\Services\Stripe\Resource;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Services\Stripe\Customer as StripeCustomer;

trait ManagesCustomer
{
    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return ! is_null($this->customer) && ! is_null($this->customerId());
    }

    /**
     * Get user business profile details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

    /**
     * Get the Stripe ID of the customer.
     *
     * @return string|null
     */
    public function customerId(): ?string
    {
        return $this->customer->stripe_id;
    }

    /**
     * Get user instance as Stripe customer.
     *
     * @return \App\Services\Stripe\Resource
     */
    public function asStripeCustomer(): Resource
    {
        return new StripeCustomer($this->customerId());
    }
}
