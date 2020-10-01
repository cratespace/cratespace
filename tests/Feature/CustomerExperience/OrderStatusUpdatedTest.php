<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Order;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Events\OrderStatusUpdatedEvent;

class OrderStatusUpdatedTest extends TestCase
{
    /** @test */
    public function an_event_is_fired_once_order_status_has_been_updated()
    {
        $user = $this->signIn();

        $order = create(Order::class, ['user_id' => $user]);

        Event::fake([OrderStatusUpdatedEvent::class]);

        $response = $this->put("/orders/{$order->confirmation_number}", [
            'status' => 'Approved',
        ]);

        Event::assertDispatched(function (OrderStatusUpdatedEvent $event) use ($order) {
            return $event->order->is($order);
        });
    }

    /** @test */
    public function an_email_is_sent_to_the_customer_once_order_status_has_been_updated()
    {
        $user = $this->signIn();

        $order = create(Order::class, ['user_id' => $user]);

        Mail::fake();

        Mail::assertNothingSent();

        $response = $this->put("/orders/{$order->confirmation_number}", [
            'status' => 'Approved',
        ]);

        Mail::assertQueued(function (OrderStatusUpdatedMail $mail) use ($order) {
            return $mail->order->id === $order->id && $mail->hasTo($order->email);
        });
    }
}
