<?php

namespace App\Billing\Stripe\Concerns;

use Stripe\Customer;
use Illuminate\Support\Collection;
use Stripe\Service\CustomerService;

trait ManagesCustomers
{
    /**
     * Create new Stripe customer.
     *
     * @param array $data
     *
     * @return \Stripe\Customer
     */
    public function createCustomer(array $data): Customer
    {
        return $this->customers()->create($data);
    }

    /**
     * Get the customer with the given ID.
     *
     * @param string $id
     *
     * @return \Stripe\Customer
     */
    public function getCustomer(string $id): Customer
    {
        return $this->customers()->retrieve($id);
    }

    /**
     * Update the given customer with the given details.
     *
     * @param string $id
     * @param array  $data
     *
     * @return \Stripe\Customer
     */
    public function updateCustomer(string $id, array $data = []): Customer
    {
        return $this->customers()->update($id, $data);
    }

    /**
     * Delete the given customer.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteCustomer(string $id): bool
    {
        $response = $this->customers()->delete($id);

        return $response->deleted;
    }

    /**
     * Get all customers registered to Cratespace.
     *
     * @param array|null $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public function allCustomers(?array $filters = null): Collection
    {
        return collect($this->customers()->all($filters));
    }

    /**
     * Get stripe customer service.
     *
     * @return \Stripe\Service\CustomerService
     */
    public function customers(): CustomerService
    {
        return $this->client->customers;
    }
}
