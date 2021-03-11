<?php

namespace App\Actions\Business;

use App\Models\Customer;
use App\Billing\Clients\Stripe;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;

class CreateNewCustomer implements CreatesNewUsers
{
    /**
     * Create new instance of create customer action.
     *
     * @param \App\Billing\Clients\Stripe $client
     *
     * @return void
     */
    public function __construct(Stripe $client)
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
        $customer = $this->client->createCustomer([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'description' => 'Cratespace customer no. ' . $data['user']->id,
        ]);

        Customer::create([
            'user_id' => $data['user']->id,
            'stripe_id' => $customer->id,
        ]);

        $data['user']->assignRole('Customer');

        return $data['user']->fresh();
    }
}
