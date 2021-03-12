<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;

class OrderTest extends TestCase
{
    public function testBelongsToSpace()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(Space::class, $order->space);
    }

    public function testCanGetBusinessUser()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withBusiness()->create();
        $space = create(Space::class, ['user_id' => $user->id]);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($order->user->is($user));
    }

    public function testCanGetCustomer()
    {
        $user = User::factory()->asCustomer()->create();
        $order = create(Order::class, ['customer_id' => $user->id]);

        $this->assertTrue($order->customer->is($user));
    }

    public function testCancellation()
    {
        $space = create(Space::class);
        $order = create(Order::class, ['space_id' => $space->id]);

        $order->cancel();

        $this->assertNull($space->order);
    }
}
