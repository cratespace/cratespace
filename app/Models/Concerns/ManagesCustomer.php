<?php

namespace App\Models\Concerns;

use App\Models\User;
use App\Models\Customer;
use App\Services\Stripe\Resource;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Services\Stripe\Customer as StripeCustomer;

trait ManagesCustomer
{
    /**
     * Create user as customer type account.
     *
     * @param array|null $data
     *
     * @return \App\Models\User
     */
    public function createAsCustomer(?array $data = null): User
    {
        if (is_null($data)) {
            $data = $this->toArray();
        }

        $customer = StripeCustomer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        Customer::create([
            'user_id' => $this->id,
            'stripe_id' => $customer->id,
        ]);

        return $this;
    }

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
