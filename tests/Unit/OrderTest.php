<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_be_marked_as_confirmed_completed_canceled()
    {
        $order = create(Order::class);

        $order->markAs('Confirmed');
        $this->assertEquals('Confirmed', $order->refresh()->status);

        $order->markAs('Completed');
        $this->assertEquals('Completed', $order->refresh()->status);

        $order->markAs('Canceled');
        $this->assertEquals('Canceled', $order->refresh()->status);
    }

    /** @test */
    public function it_can_auto_generate_a_unique_id()
    {
        $order = create(Order::class, ['uid' => null]);

        $this->assertTrue(isset($order->uid));
        $this->assertDatabaseHas('orders', ['uid' => $order->uid]);
    }

    /** @test */
    public function it_has_a_path()
    {
        $order = create(Order::class);

        $this->assertEquals("/orders/{$order->uid}", $order->path());
    }
}
