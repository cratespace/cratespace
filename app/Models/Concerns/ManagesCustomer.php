<?php

namespace App\Models\Concerns;

use App\Models\Customer;
use App\Exceptions\InvalidCustomerException;

trait ManagesCustomer
{
    /**
     * Determine the user is a customer.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        if (is_null($this->profile)) {
            return false;
        }

        if ($this->profile instanceof Customer) {
            return ! is_null($this->profile->stripe_id);
        }

        return false;
    }

    /**
     * Get user's Stripe ID.
     *
     * @return string|null
     */
    public function customerId(): ?string
    {
        if (! $this->isCustomer()) {
            throw new InvalidCustomerException("User [$this->name] is not a valid customer");
        }

        return $this->profile->stripe_id;
    }
}
