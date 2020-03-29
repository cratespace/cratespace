<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageOrdersTest extends TestCase
{
    /** @test */
    public function only_authenticated_user_can_view_their_orders()
    {
        $this->get('/orders?status=Pending')->assertRedirect('/login');

        $this->signIn();

        $this->get('/orders?status=Pending')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_only_view_orders_that_belong_to_them()
    {
        $john = $this->signIn(create(User::class, ['name' => 'John Doe']));
        $james = create(User::class);

        $johnsOrder = create(Order::class, ['user_id' => $john->id, 'status' => 'Pending']);
        $jamesOrder = create(Order::class, ['user_id' => $james->id, 'status' => 'Pending']);

        $this->get('/orders?status=Pending')
            ->assertSee($johnsOrder->uid)
            ->assertDontSee($jamesOrder->uid);
    }

    /** @test */
    public function only_autherized_users_can_update_order_status()
    {
        $john = $this->signIn(create(User::class, ['name' => 'John Doe']));
        $johnsOrder = create(Order::class, ['user_id' => $john->id, 'status' => 'Pending']);

        $james = create(User::class);
        $jamesOrder = create(Order::class, ['user_id' => $james->id, 'status' => 'Pending']);

        $this->put('/orders/' . $johnsOrder->uid, ['status' => 'Confirmed'])
            ->assertStatus(200);

        $this->put('/orders/' . $jamesOrder->uid, ['status' => 'Confirmed'])
            ->assertStatus(403);

        $this->assertEquals('Confirmed', $johnsOrder->refresh()->status);
        $this->assertEquals('Pending', $jamesOrder->refresh()->status);
    }

    /** @test */
    public function users_can_filter_orders_by_status()
    {
        $user = $this->signIn();

        $pendingOrder = create(Order::class, ['user_id' => $user->id, 'status' => 'Pending']);
        $completedOrder = create(Order::class, ['user_id' => $user->id, 'status' => 'Completed']);

        $this->get('/orders?status=Completed')
            ->assertSee($completedOrder->uid)
            ->assertDontSee($pendingOrder->uid);
    }
}
