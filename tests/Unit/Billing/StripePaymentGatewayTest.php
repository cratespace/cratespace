<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Tests\Fixtures\MockProduct;
use App\Services\Stripe\Customer;
use App\Contracts\Billing\Payment;
use Illuminate\Support\Facades\Event;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Billing\PaymentGateways\StripePaymentGateway;

class StripePaymentGatewayTest extends TestCase
{
    public function testInstantiation()
    {
        $paymentGateway = new StripePaymentGateway();

        $this->assertInstanceOf(PaymentGateway::class, $paymentGateway);
    }

    public function testGetCustomer()
    {
        $customer = Customer::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);
        $paymentGateway = new StripePaymentGateway();
        $paymentCustomer = $paymentGateway->getCustomer($customer->id);

        $this->assertInstanceOf(Customer::class, $paymentCustomer);
        $this->assertEquals($customer->id, $paymentCustomer->id);
    }

    public function testMakeCharge()
    {
        Event::fake();

        $product = new MockProduct('test_product');
        $paymentGateway = new StripePaymentGateway();
        $payment = $paymentGateway->charge($product->fullAmount(), array_merge($details = [
            'name' => 'James Silverman',
            'email' => 'j.silvermo@monster.com',
            'phone' => '0712345678',
            'payment_method' => 'pm_card_visa',
            'metadata' => [],
        ], ['customer' => Customer::create($details)->id]));

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals($payment->amount, $product->fullAmount());
    }
}
