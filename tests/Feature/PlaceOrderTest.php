<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

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

        $this->post(route('orders.store'), [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'business' => 'Example Compny',
            'phone' => '776688899'
        ]);

        $this->assertDatabaseHas('orders', ['uid' => Order::first()->uid]);

        $this->assertFalse(cache()->has('space'));
    }
}
