<?php

namespace Tests\Unit\Stripe;

use Throwable;
use Tests\TestCase;
use App\Support\Money;
use Stripe\PaymentIntent;
use App\Services\Stripe\Payment;
use App\Exceptions\PaymentActionRequired;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\Payment as PaymentContract;

/**
 * @group Stripe
 */
class PaymentTest extends TestCase
{
    public function testCreatePayment()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
        ]);

        $this->assertInstanceOf(PaymentContract::class, $payment);
        $this->assertEquals('succeeded', $payment->status);
        $this->assertTrue($payment->paid());
        $this->assertTrue($payment->isSucceeded());
        $this->assertFalse($payment->isCancelled());
    }

    public function testPaymentCanBeCancelled()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'confirm' => false,
        ]);

        $payment->cancel();

        $payment->refresh();

        $this->assertEquals('canceled', $payment->status);
        $this->assertFalse($payment->paid());
        $this->assertFalse($payment->isSucceeded());
        $this->assertTrue($payment->isCancelled());
    }

    public function testPaymentAdheresToContract()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
        ]);

        $this->assertEquals(1000, $payment->rawAmount());
        $this->assertEquals(Money::format(1000), $payment->amount());
    }

    public function testPaymentCanBeValidated()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
        ]);

        $this->assertNull($payment->validate());
    }

    public function testPaymentWithoutPaymentMethodCanBeValidated()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'confirm' => false,
        ]);

        try {
            $payment->validate();
        } catch (Throwable $e) {
            $this->assertInstanceOf(PaymentFailedException::class, $e);
            $this->assertEquals('The payment attempt failed because of an invalid payment method.', $e->getMessage());

            return;
        }

        $this->fail();
    }

    public function testPaymentWithActionRequirementsCanBeValidated()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_threeDSecureRequired',
            'confirm' => true,
        ]);

        try {
            $payment->validate();
        } catch (Throwable $e) {
            $this->assertInstanceOf(PaymentActionRequired::class, $e);
            $this->assertEquals('The payment attempt failed because additional action is required before it can be completed.', $e->getMessage());

            return;
        }

        $this->fail();
    }

    public function testReturnItsRequiresPaymentMethodStatus()
    {
        $paymentIntent = new PaymentIntent();
        $paymentIntent->status = 'requires_payment_method';
        $payment = new Payment($paymentIntent);

        $this->assertTrue($payment->requiresPaymentMethod());
    }

    public function testReturnItsRequiresActionStatus()
    {
        $paymentIntent = new PaymentIntent();
        $paymentIntent->status = 'requires_action';
        $payment = new Payment($paymentIntent);

        $this->assertTrue($payment->requiresAction());
    }

    public function testReturnItsCancelledStatus()
    {
        $paymentIntent = new PaymentIntent();
        $paymentIntent->status = 'canceled';
        $payment = new Payment($paymentIntent);

        $this->assertTrue($payment->isCancelled());
    }

    public function testReturnItsSucceededStatus()
    {
        $paymentIntent = new PaymentIntent();
        $paymentIntent->status = 'succeeded';
        $payment = new Payment($paymentIntent);

        $this->assertTrue($payment->isSucceeded());
    }
}
