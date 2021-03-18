<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Tests\Concerns\HasBillingClient;

class CustomerTest extends TestCase
{
    use HasBillingClient;

    public function testCreateAndGetCustomer()
    {
        $client = $this->getClient();
        $customer = $client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $this->assertEquals(
            $customer->name,
            $client->getCustomer($customer->id)->name
        );
    }

    public function testUpdateCustomerDetails()
    {
        $client = $this->getClient();
        $customer = $client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $client->updateCustomer($customer->id, [
            'name' => 'Cratespace Customer',
        ]);

        $this->assertEquals(
            $client->getCustomer($customer->id)->name,
            'Cratespace Customer'
        );
    }

    public function testDeleteCustomer()
    {
        $client = $this->getClient();
        $customer = $client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $client->deleteCustomer($customer->id);

        $this->assertNull($client->getCustomer($customer->id)->name);
    }

    public function testGetAllCustomers()
    {
        $client = $this->getClient();
        $customers = $client->allCustomers();

        $this->assertInstanceOf(Collection::class, $customers);
        $this->assertTrue($customers->count() > 0);
    }
}
