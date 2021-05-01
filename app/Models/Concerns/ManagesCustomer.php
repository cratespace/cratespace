<?php

namespace App\Models\Concerns;

use App\Models\User;
use App\Exceptions\CustomerAlreadyCreated;

trait ManagesCustomer
{
    public function createCustomerProfile(array $data): User
    {
        if (! is_null($this->customerId())) {
            throw CustomerAlreadyCreated::exists($this);
        }

        $customer = StripeCustomer::create();

        $this->customer()->create([
            'email' => $this->email,
            'stripe_id' => $customer->id,
        ]);

        return $this;
    }
}
