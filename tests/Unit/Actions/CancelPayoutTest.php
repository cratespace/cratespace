<?php

namespace Tests\Unit\Actions;

use Throwable;
use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Models\Payout;
use Illuminate\Support\Str;
use App\Contracts\Billing\Payment;
use App\Actions\Business\CancelPayout;
use App\Exceptions\InvalidActionException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CancelPayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testCancelPayout()
    {
        $payment = m::mock(Payment::class);
        $payment->id = Str::random(40);

        $payout = Payout::create([
            'payment' => $payment->id,
            'user_id' => create(User::class)->id,
            'amount' => 1000,
            'service_percentage' => 0.03,
        ]);

        $canceller = new CancelPayout();
        $canceller->cancel($payment);

        $this->assertNull($payout->fresh());
    }

    public function testCannotCancelPaidPayout()
    {
        $payment = m::mock(Payment::class);
        $payment->id = Str::random(40);

        $payout = Payout::create([
            'payment' => $payment->id,
            'user_id' => create(User::class)->id,
            'amount' => 1000,
            'service_percentage' => 0.03,
        ]);

        $payout->pay();

        $canceller = new CancelPayout();

        try {
            $canceller->cancel($payment);
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidActionException::class, $e);
            $this->assertEquals('Payout has already been paid for', $e->getMessage());

            return;
        }

        $this->fail();
    }
}
