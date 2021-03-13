<?php

namespace App\Models\Concerns;

use App\Models\Customer;

trait ManagesCustomer
{
    /**
     * Determine the user is a customer.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
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
            return null;
        }

        return $this->profile->stripe_id;
    }
}
