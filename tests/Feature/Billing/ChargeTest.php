<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use App\Models\User;
use App\Support\Money;
use App\Contracts\Billing\Payment;
use App\Billing\Gateways\StripeGateway;

class ChargeTest extends TestCase
{
    public function testCustomerCanBeCharged()
    {
        $paymentGateway = $this->app->make(StripeGateway::class);
        $customer = User::factory()->asCustomer()->create();
        $this->signIn($customer);

        $payment = $paymentGateway->charge(1000, 'pm_card_visa', [
            'customer' => $customer->customerId(),
        ]);

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals(Money::format(1000), $payment->amount());
        $this->assertEquals(1000, $payment->rawAmount());
        $this->assertTrue($payment->isSucceeded());
        $this->assertEquals($customer->customerId(), $payment->customer);
    }
}
