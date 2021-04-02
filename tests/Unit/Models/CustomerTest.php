<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Stripe\Customer as StripeCustomer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser()
    {
        $customer = create(Customer::class);

        $this->assertInstanceOf(User::class, $customer->user);
    }

    public function testCustomerIsAlsoStripeCustomer()
    {
        $stripeCustomer = StripeCustomer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $customer = create(Customer::class, [
            'stripe_id' => $stripeCustomer->id,
        ]);

        $this->assertEquals($stripeCustomer->id, $customer->details->id);

        $customer->details->delete();
    }
}
