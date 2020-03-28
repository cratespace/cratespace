<?php

namespace Tests\Unit;

use stdClass;
use Tests\TestCase;
use ReflectionClass;
use App\Models\Order;
use Illuminate\Support\Collection;
use App\Maintainers\OrdersMaintainer;

class OrdersMaintainerTest extends TestCase
{
    /** @test */
    public function it_can_update_the_status_of_all_avilable_orders()
    {
        create(Order::class, [
            'user_id' => $this->signIn()->id,
            'status' => 'Pending'
        ], 1);

        $orders = new OrdersMaintainer('orders');
        $order = Order::find($orders->getResource()->first()->id);
        $order->markAs('Pending');

        $this->assertEquals('Pending', $order->status);

        $order->space()->update(['departs_at' => now()->subMonth()]);
        $reflection = new ReflectionClass($orders);
        $method = $reflection->getMethod('updateOrderStatus');
        $method->setAccessible(true);
        $method->invokeArgs($orders, []);
        $this->assertTrue($order->refresh()->status == 'Canceled');
    }
}
