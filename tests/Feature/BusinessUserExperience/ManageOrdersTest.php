<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

class ManageOrdersTest extends TestCase
{
    /** @test */
    public function authorized_users_can_only_view_their_own_space_orders_listings()
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
}
