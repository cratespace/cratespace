<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Order;
use App\Actions\Product\CreateNewOrder;
use App\Contracts\Actions\MakesPurchases;
use App\Billing\PaymentTokens\DestroyPaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateMockOrder()
    {
        $order = m::mock(Order::class);
        $product = new MockProduct(1);
        $token = Str::random(40);

        $destroyer = m::mock(DestroyPaymentToken::class);
        $destroyer->shouldReceive('destroy')
            ->once()
            ->with($token);
        $purchaser = m::mock(MakesPurchases::class);
        $purchaser->shouldReceive('purchase')
            ->once()
            ->with($product, ['payment_token' => $token])
            ->andReturn($order);

        $creator = new CreateNewOrder($purchaser, $destroyer);
        $orderPlaced = $creator->create($product, ['payment_token' => $token]);

        $this->assertInstanceOf(Order::class, $orderPlaced);
        $this->assertEquals($order, $orderPlaced);
    }
}
