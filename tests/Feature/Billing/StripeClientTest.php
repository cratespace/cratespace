<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use Stripe\StripeClient;
use App\Billing\Stripe\Client;
use Stripe\StripeClientInterface;
use Illuminate\Support\Collection;
use App\Contracts\Billing\Client as ClientContract;

class StripeClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client($this->getStripeClient());
    }

    public function testInstancetiation()
    {
        $this->assertInstanceOf(ClientContract::class, $this->client);
    }

    public function testCreateAndGetCustomer()
    {
        $customer = $this->client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $this->assertEquals(
            $customer->name,
            $this->client->getCustomer($customer->id)->name
        );
    }

    public function testUpdateCustomerDetails()
    {
        $customer = $this->client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $this->client->updateCustomer($customer->id, [
            'name' => 'Cratespace Customer',
        ]);

        $this->assertEquals(
            $this->client->getCustomer($customer->id)->name,
            'Cratespace Customer'
        );
    }

    public function testDeleteCustomer()
    {
        $customer = $this->client->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'description' => 'Cratespace customer.',
        ]);

        $this->client->deleteCustomer($customer->id);

        $this->assertNull($this->client->getCustomer($customer->id)->name);
    }

    public function testGetAllCustomers()
    {
        $customers = $this->client->allCustomers();

        $this->assertInstanceOf(Collection::class, $customers);
        $this->assertTrue($customers->count() > 0);
    }

    /**
     * Get instance of Stripe client.
     *
     * @return \Stripe\StripeClientInterface
     */
    protected function getStripeClient(): StripeClientInterface
    {
        return new StripeClient(config('billing.secret'));
    }
}
