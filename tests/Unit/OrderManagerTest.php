<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Resources\Orders\Manager;

class OrderManagerTest extends TestCase
{
    /** @test */
    public function it_can_process_a_request_for_an_order()
    {
        $this->getManager()->process($this->orderRequestContentStub());

        $order = Order::first();

        $this->assertDatabaseHas('orders', ['uid' => $order->uid]);
        $this->assertEquals('Thavarshan', $order->name);
        $this->assertArrayHasKey('tax', $order->toArray());
        $this->assertArrayHasKey('total', $order->toArray());
        $this->assertArrayHasKey('service', $order->toArray());
        $this->assertEquals(1000, $order->space->price);
    }

    /**
     * Fake request for new order.
     *
     * @return array
     */
    protected function orderRequestContentStub()
    {
        $space = create(Space::class, [
            'price' => 1000
        ]);

        return [
            'name' => 'Thavarshan',
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'space_id' => $space->id,
        ];
    }

    /**
     * Get new instance of order manager.
     *
     * @return \App\Resources\Orders\Manager
     */
    protected function getManager()
    {
        return new Manager;
    }
}
