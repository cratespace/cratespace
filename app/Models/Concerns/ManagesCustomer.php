<?php

namespace App\Models\Concerns;

use App\Models\Customer;
use App\Services\Stripe\Customer as StripeCustomer;

trait ManagesCustomer
{
    /**
     * Create user as customer type account.
     *
     * @param array|null $data
     *
     * @return void
     */
    public function createAsCustomer(?array $data = null): void
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
    }
}
