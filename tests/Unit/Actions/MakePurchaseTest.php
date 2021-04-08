<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Tests\TestCase;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Order;
use App\Actions\Product\MakePurchase;
use App\Billing\PaymentGateways\PaymentGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentGateways\FakePaymentGateway;

class MakePurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(
            PaymentGateway::class,
            FakePaymentGateway::class
        );
    }

    protected function tearDown(): void
    {
        m::close();
    }

    public function testFakePurchaseTest()
    {
        $paymentGateway = $this->app->make(PaymentGateway::class);
        $token = $paymentGateway->getValidTestToken();
        $product = new MockProduct('test_product');
        $purchaser = new MakePurchase($paymentGateway);

        $order = $purchaser->purchase($product, [
            'token' => $token,
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($product->fullAmount(), $order->payment->rawAmount());
    }
}
