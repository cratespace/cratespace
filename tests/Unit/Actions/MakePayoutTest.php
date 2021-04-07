<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\Stripe\Payment;
use App\Actions\Business\MakeNewPayout;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakePayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testMakeMockPayoutForBusiness()
    {
        config()->set('billing.service', 0.03);

        $user = User::factory()->asBusiness()->create();
        $maker = $this->app->make(MakeNewPayout::class);
        $payment = m::mock(Payment::class);
        $payment->id = Str::random(40);
        $payment->amount = 1000;
        $payment->shouldReceive('rawAmount')
            ->once()
            ->with()
            ->andReturn(1000);

        $payout = $maker->make($user, $payment);

        $this->assertEquals(970, $payout->rawAmount());
        $this->assertFalse($payout->paid());
        $this->assertEquals(0.03, $payout->service_percentage);
    }
}
