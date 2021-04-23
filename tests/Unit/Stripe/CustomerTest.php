<?php

namespace Tests\Unit\Stripe;

use Tests\TestCase;
use App\Services\Stripe\Customer;
use App\Services\Stripe\Resource;
use Illuminate\Support\Collection;

/**
 * @group Stripe
 */
class CustomerTest extends TestCase
{
    public function testCreateCustomer()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $this->assertInstanceOf(Customer::class, $customer);

        $deletable = new Customer($customer);
        $deletable->delete();
    }

    public function testGetCustomer()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $stripeCustomer = Customer::get($customer->id);

        $this->assertInstanceOf(Resource::class, $stripeCustomer);
        $this->assertEquals($customer->name, $stripeCustomer->name);

        $deletable = new Customer($customer);
        $deletable->delete();
    }

    public function testGetAllCustomers()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $this->assertInstanceOf(Collection::class, Customer::all());

        $deletable = new Customer($customer);

        $this->assertTrue(
            Customer::all()->contains(function ($value, $key) use ($deletable) {
                return $deletable->id === $value->id;
            })
        );

        $deletable->delete();
    }
}
