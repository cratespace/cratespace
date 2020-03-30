<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Events\OrderPlaced;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewOrderPlaced;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Mail\OrderPendingConfirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class PlaceOrderTest extends TestCase
{
    /** @test */
    public function a_customer_can_place_an_order_for_a_space()
    {
        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->get('/')
             ->assertStatus(200)
             ->assertSee($space->uid);

        $this->post(route('checkout.store', $space))
            ->assertRedirect('/checkout');

        $this->assertTrue(cache()->has('space'));

        $response = $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Company',
            'phone' => '776688899',
            'payment_type' => 'cash'
        ]);

        $order = Order::first();

        $this->assertDatabaseHas('orders', ['uid' => $order->uid]);
        $this->assertTrue($space->user->account->credit !== 0);
        $this->assertFalse(cache()->has('space'));
        $this->assertFalse(cache()->has('prices'));
    }

    /** @test */
    public function an_event_is_dispatched_when_an_order_is_created()
    {
        $initialEvent = Event::getFacadeRoot();
        Event::fake();
        Model::setEventDispatcher($initialEvent);

        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->post(route('checkout.store', $space))
            ->assertRedirect('/checkout');

        $this->assertTrue(cache()->has('space'));

        $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Company',
            'phone' => '776688899',
            'payment_type' => 'cash'
        ]);

        $order = Order::first();

        Event::assertDispatched(OrderPlaced::class, function ($e) use ($order) {
            return $e->getOrder()->id === $order->id;
        });
    }

    /** @test */
    public function a_customer_receives_an_email_on_successful_purchase()
    {
        Mail::fake();

        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->post(route('checkout.store', $space))
            ->assertRedirect('/checkout');

        $this->assertTrue(cache()->has('space'));

        $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Company',
            'phone' => '776688899',
            'payment_type' => 'cash'
        ]);

        $order = Order::first();

        Mail::assertSent(OrderPendingConfirmation::class, function ($mail) use ($order) {
            return $mail->hasTo($order->email) &&
               $mail->hasCc($order->user->business->email);
        });
    }

    /** @test */
    public function the_related_business_receives_a_notification_when_an_order_is_placed()
    {
        Notification::fake();

        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->post(route('checkout.store', $space))
            ->assertRedirect('/checkout');

        $this->assertTrue(cache()->has('space'));

        $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Company',
            'phone' => '776688899',
            'payment_type' => 'cash'
        ]);

        $order = Order::first();

        Notification::assertSentTo(
            $order->user,
            NewOrderPlaced::class,
            function ($notification, $channels) use ($order) {
                return $notification->getOrder()->id === $order->id;
            }
        );
    }
}
