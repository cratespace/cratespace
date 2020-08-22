<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Events\OrderStatusUpdatedEvent;

class ManageOrdersTest extends TestCase
{
    /** @test */
    public function only_authorized_users_can_view_their_own_space_orders_listings()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $orderOfUser = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);
        $genericOrder = create(Order::class);

        $this->get('/orders')
            ->assertStatus(200)
            ->assertSee($orderOfUser->confirmation_number)
            ->assertDontSee($genericOrder->confirmation_number);
    }

    /** @test */
    public function only_authorized_users_can_view_their_own_space_order_details()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $orderOfUser = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);
        $genericOrder = create(Order::class);

        $this->get("/spaces/{$genericOrder->space->code}")
            ->assertStatus(403);

        $this->get("/spaces/{$orderOfUser->space->code}")
            ->assertStatus(200)
            ->assertSee($orderOfUser->confirmation_number)
            ->assertSee($orderOfUser->name)
            ->assertSee($orderOfUser->email)
            ->assertSee($orderOfUser->phone)
            ->assertSee($orderOfUser->space->code);
    }

    /** @test */
    public function only_authorized_users_can_update_order_details()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $orderOfUser = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals('Pending', $orderOfUser->status);

        $this->actingAs($user)
            ->from("/spaces/{$orderOfUser->space->code}")
            ->put("/orders/{$orderOfUser->confirmation_number}", [
                'status' => 'Approved',
            ])
            ->assertRedirect("/spaces/{$orderOfUser->space->code}");

        $this->assertEquals('Approved', $orderOfUser->refresh()->status);

        auth()->logout();

        $this->actingAs(create(User::class))
            ->from("/spaces/{$orderOfUser->space->code}")
            ->put("/orders/{$orderOfUser->confirmation_number}", [
                'status' => 'Approved',
            ])
            ->assertStatus(403);
    }

    /** @test */
    public function update_order_status_triggers_an_event()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $orderOfUser = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);

        Event::fake([
            OrderStatusUpdatedEvent::class,
        ]);

        $this->actingAs($user)
            ->from("/spaces/{$orderOfUser->space->code}")
            ->put("/orders/{$orderOfUser->confirmation_number}", [
                'status' => 'Approved',
            ]);

        Event::assertDispatched(function (OrderStatusUpdatedEvent $event) use ($orderOfUser) {
            return $event->order->id === $orderOfUser->id;
        });
    }

    /** @test */
    public function update_order_status_triggers_an_email_notification()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $orderOfUser = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);

        Mail::fake([
            OrderStatusUpdatedMail::class,
        ]);

        $this->actingAs($user)
            ->from("/spaces/{$orderOfUser->space->code}")
            ->put("/orders/{$orderOfUser->confirmation_number}", [
                'status' => 'Approved',
            ]);

        Mail::assertQueued(function (OrderStatusUpdatedMail $event) use ($orderOfUser) {
            return $event->order->id === $orderOfUser->id;
        });
    }
}
