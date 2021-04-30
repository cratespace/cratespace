<?php

namespace Tests\Unit\Stripe;

use Tests\TestCase;
use App\Support\Money;
use App\Services\Stripe\Refund;
use App\Services\Stripe\Payment;

/**
 * @group Stripe
 */
class RefundTest extends TestCase
{
    public function testCreateRefund()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
        ]);

        $refund = Refund::create([
            'amount' => 1000,
            'payment_intent' => $payment->id,
            'reason' => 'requested_by_customer',
        ]);

        $this->assertInstanceOf(Refund::class, $refund);
    }
}
