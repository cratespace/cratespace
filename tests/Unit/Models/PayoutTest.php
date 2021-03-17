<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payout;
use App\Support\Money;
use App\Contracts\Billing\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayoutTest extends TestCase
{
    use RefreshDatabase;

    public function testImplementsPaymentContract()
    {
        $payout = new Payout();

        $this->assertInstanceOf(Payment::class, $payout);
    }

    public function testBelongsToBusiness()
    {
        $payout = create(Payout::class);

        $this->assertInstanceOf(User::class, $payout->user);
    }

    public function testPayoutContainsServicePercentageDetails()
    {
        $payout = create(Payout::class, [
            'service_percentage' => 0.03,
        ]);

        $this->assertEquals(0.03, $payout->service_percentage);
    }

    public function testPayoutContainsPayAmountDetails()
    {
        $payout = create(Payout::class);

        $this->assertNotNull($payout->amount);
    }

    public function testPayoutStatus()
    {
        $payout = create(Payout::class, [
            'paid_at' => now(),
        ]);

        $this->assertEquals('paid', $payout->status());
    }

    public function testPayoutCanFormatAmount()
    {
        $payout = create(Payout::class, [
            'amount' => 1000,
        ]);

        $this->assertEquals(Money::format(1000), $payout->amount());
    }
}
