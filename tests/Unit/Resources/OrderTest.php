<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_calculate_total_amount_and_present_in_currency_format()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'price' => $space->getPriceInCents(),
            'tax' => $space->getTaxInCents(),
        ]);

        $this->assertTrue(is_string($order->total));
        $this->assertEquals('$49.50', $order->total);
    }

    /** @test */
    public function it_can_caluculate_charges_dynamically()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals(3250, $order->price);
        $this->assertEquals(50, $order->tax);
        $this->assertEquals(1650, $order->service);
    }

    /** @test */
    public function it_can_caluculate_service_charges_dynamically()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals(1650, $order->service);
        $this->assertEquals(1650, $order->getServiceCharge());
    }

    /** @test */
    public function it_can_caluculate_service_charges_total_in_cents()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals(4950, $order->totalInCents());
    }

    /** @test */
    public function it_can_cancel_itself_and_release_any_space_associated()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertFalse($space->isAvailable());

        $order->cancel();

        $this->assertTrue($space->isAvailable());
        $this->assertDatabaseMissing('orders', [
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);
    }
}
