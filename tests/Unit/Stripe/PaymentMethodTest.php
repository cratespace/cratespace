<?php

namespace Tests\Unit\Stripe;

use Tests\TestCase;
use App\Services\Stripe\Customer;
use App\Services\Stripe\PaymentMethod;

class PaymentMethodTest extends TestCase
{
    /**
     * The payment method instance.
     *
     * @var string
     */
    protected $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentMethod = PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 4,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ]);
    }

    public function testCreatePaymentMethod()
    {
        $this->assertInstanceOf(PaymentMethod::class, $this->paymentMethod);
    }

    public function testAttachPaymentMethodToCustomer()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $this->paymentMethod->attach($customer);
        $this->paymentMethod->refresh();

        $this->assertEquals($customer->id, $this->paymentMethod->customer);
    }

    public function testDettachPaymentMethodFromCustomer()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        $this->paymentMethod->attach($customer);
        $this->paymentMethod->refresh();

        $this->paymentMethod->detach();
        $this->paymentMethod->refresh();

        $this->assertNull($this->paymentMethod->customer);
    }
}
