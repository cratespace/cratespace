<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Mail\OrderPendingConfirmation;

class PlaceOrderTest extends TestCase
{
    /** @test */
    public function a_customer_can_place_an_order_for_a_space()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->get('/')
             ->assertStatus(200)
             ->assertSee($space->uid);

        $this->post(route('checkout.store', $space))
            ->assertRedirect('/checkout');

        $this->assertTrue(cache()->has('space'));

        $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Compny',
            'phone' => '776688899'
        ]);

        $order = Order::first();

        $this->assertDatabaseHas('orders', ['uid' => $order->uid]);

        $this->assertTrue($space->user->account->credit !== 0);

        Mail::assertSent(OrderPendingConfirmation::class, function ($mail) use ($order) {
            return $mail->hasTo($order->email) &&
               $mail->hasCc($order->user->business->email);
        });

        $this->assertFalse(cache()->has('space'));
        $this->assertFalse(cache()->has('prices'));
    }
}
