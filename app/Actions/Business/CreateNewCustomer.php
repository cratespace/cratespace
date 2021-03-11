<?php

namespace App\Actions\Business;

use Stripe\StripeClientInterface;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;

class CreateNewCustomer implements CreatesNewUsers
{
    /**
     * Create new instance of create customer action.
     *
     * @param \Stripe\StripeClientInterface $client
     *
     * @return void
     */
    public function __construct(StripeClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data): User
    {
        $customer = $this->client->customers->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'description' => 'Cratespace customer no. ' . $data['user']->id,
        ]);

        $data['user']->update([
            'stripe_id' => $customer->id,
        ]);

        return $data['user']->fresh();
    }
}
