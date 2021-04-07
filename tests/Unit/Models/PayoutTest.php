<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payout;
use App\Support\Money;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Payment;
use App\Contracts\Billing\Product;
use App\Services\Stripe\Payment as StripePayment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayoutTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToBusiness()
    {
        $payout = create(Payout::class);

        $this->assertInstanceOf(User::class, $payout->user);
    }

    public function testCanFormatAmountToPresentableValue()
    {
        $payout = create(Payout::class);

        $this->assertEquals(Money::format($payout->amount), $payout->amount());
    }

    public function testDeterminePaidStatus()
    {
        $payout = create(Payout::class);

        $this->assertFalse($payout->paid());

        $payout->pay();

        $this->assertTrue($payout->fresh()->paid());
    }

    public function testCastPaymentAsPaymentObject()
    {
        $payout = create(Payout::class);

        $this->assertInstanceOf(Payment::class, $payout->payment);
    }

    public function testCanGetProductDetails()
    {
        $product = new MockProduct('test_product');

        $payment = StripePayment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
            'metadata' => [
                'product_code' => $product->code(),
            ],
        ]);

        $payout = Payout::create([
            'payment' => $payment->id,
            'amount' => $payment->amount,
            'service_percentage' => 0.0,
            'user_id' => User::factory()->asBusiness()->create()->id,
            'paid_at' => null,
        ]);

        $this->assertInstanceOf(Product::class, $payout->product());
        $this->assertEquals($product->name(), $payout->product()->name());
    }
}
