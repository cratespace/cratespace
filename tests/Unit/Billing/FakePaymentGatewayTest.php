<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Contracts\Billing\Payment;
use App\Billing\PaymentGateways\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
    public function testMakeCharge()
    {
        $paymentGateway = new FakePaymentGateway();

        $payment = $paymentGateway->charge(1000, [
            'token' => $paymentGateway->getValidTestToken(),
        ]);

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals(1000, $payment->rawAmount());
        $this->assertEquals(1000, $paymentGateway->getTotalCharge());
        $this->assertTrue($paymentGateway->successful());
        $this->assertTrue($payment->paid());
    }

    public function testMakeMultipleCharges()
    {
        $paymentGateway = new FakePaymentGateway();
        $token = $paymentGateway->getValidTestToken();

        $payment1 = $paymentGateway->charge(1000, compact('token'));
        $payment2 = $paymentGateway->charge(2000, compact('token'));
        $payment3 = $paymentGateway->charge(4500, compact('token'));

        $this->assertEquals(1000, $payment1->rawAmount());
        $this->assertEquals(2000, $payment2->rawAmount());
        $this->assertEquals(4500, $payment3->rawAmount());
        $this->assertEquals(7500, $paymentGateway->getTotalCharge());
    }
}
