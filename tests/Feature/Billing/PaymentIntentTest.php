<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Tests\Concerns\HasBillingClient;

class PaymentIntentTest extends TestCase
{
    use HasBillingClient;

    public function testCreateAndGetPaymentIntent()
    {
        $client = $this->getClient();
        $paymentIntent = $client->createIntent([
            'amount' => 1000,
            'currency' => config('billing.currency'),
            'confirm' => false,
            'payment_method' => 'pm_card_visa',
            'description' => 'Cratespace customer payment intent.',
        ]);

        $this->assertEquals(
            $paymentIntent->amount,
            $client->getIntent($paymentIntent->id)->amount
        );
    }

    public function testConfirmPaymentIntent()
    {
        $client = $this->getClient();
        $paymentIntent = $client->createIntent([
            'amount' => 1000,
            'currency' => config('billing.currency'),
            'confirm' => false,
            'payment_method' => 'pm_card_visa',
            'description' => 'Cratespace customer payment intent.',
        ]);

        $paymentIntent = $client->confirmIntent(
            $paymentIntent->id,
            'pm_card_visa'
        );

        $this->assertEquals('succeeded', $paymentIntent->status);
    }

    public function testCancelPaymentIntent()
    {
        $client = $this->getClient();
        $paymentIntent = $client->createIntent([
            'amount' => 1000,
            'currency' => config('billing.currency'),
            'confirm' => false,
            'payment_method' => 'pm_card_visa',
            'description' => 'Cratespace customer payment intent.',
        ]);

        $paymentIntent = $client->cancelIntent($paymentIntent->id, 'abandoned');

        $this->assertEquals('canceled', $paymentIntent->status);
    }

    public function testGetAllPaymentIntents()
    {
        $client = $this->getClient();
        $customers = $client->allIntents();

        $this->assertInstanceOf(Collection::class, $customers);
        $this->assertTrue($customers->count() > 0);
    }
}
