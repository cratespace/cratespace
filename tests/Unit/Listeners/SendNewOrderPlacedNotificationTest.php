<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Events\OrderPlaced;
use App\Notifications\NewOrderPlaced;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendNewOrderPlacedNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testBusinessTheOrderIsMeantForIsNotified()
    {
        Notification::fake();

        $business = User::factory()->asBusiness()->create();
        $order = create(Order::class, ['user_id' => $business->id]);

        OrderPlaced::dispatch($order);

        Notification::assertSentTo($business, NewOrderPlaced::class);
    }

    public function testCustomerTheOrderIsMeantForIsNotified()
    {
        Notification::fake();

        $customer = User::factory()->asCustomer()->create();
        $order = create(Order::class, ['customer_id' => $customer->id]);

        OrderPlaced::dispatch($order);

        Notification::assertSentTo($customer, NewOrderPlaced::class);
    }
}
