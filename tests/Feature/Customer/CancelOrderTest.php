<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Jobs\CancelOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CancelOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderCanBeCancelled()
    {
        Queue::fake();
        $this->withoutEvents();

        $customer = create(User::class, [
            'password' => Hash::make('password'),
        ], 'asCustomer');
        $order = create(Order::class, ['customer_id' => $customer->id]);

        $response = $this->signIn($customer)
            ->delete("/orders/{$order->code}", [
                'password' => 'password',
            ]);

        $response->assertStatus(303);
    }

    public function testOrderCancellationTriggersEvent()
    {
        Queue::fake();
        $this->withoutEvents();

        $customer = create(User::class, [
            'password' => Hash::make('password'),
        ], 'asCustomer');
        $order = create(Order::class, ['customer_id' => $customer->id]);

        $response = $this->signIn($customer)
            ->delete("/orders/{$order->code}", [
                'password' => 'password',
            ]);

        Queue::assertPushed(function (CancelOrder $job) use ($order) {
            return $job->order->is($order);
        });

        $response->assertStatus(303);
    }
}
