<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\User;
use App\Support\Money;
use App\Services\Stripe\Payment;
use App\Actions\Business\MakeNewPayout;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakePayoutTest extends TestCase
{
    use RefreshDatabase;

    public function testMakePayoutForBusiness()
    {
        config()->set('billing.service', 0.03);

        $user = User::factory()->asBusiness()->create();
        $maker = $this->app->make(MakeNewPayout::class);
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
        ]);

        $payout = $maker->make($user, $payment);

        $this->assertEquals(970, $payout->rawAmount());
        $this->assertFalse($payout->paid());
        $this->assertEquals(0.03, $payout->service_percentage);
        $this->assertEquals($payment->id, $payout->payment->id);
    }
}
