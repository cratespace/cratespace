<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Billing\Charges\Calculator;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_calculate_total_amount_and_present_in_currency_format()
    {
        [$order, $space] = $this->placeOrder();

        $this->assertEquals(4925, $order->total);
    }

    /** @test */
    public function it_can_caluculate_charges_dynamically()
    {
        [$order, $space] = $this->placeOrder();

        $this->assertEquals(3250, $order->price);
        $this->assertEquals(50, $order->tax);
        $this->assertEquals(1625, $order->service);
    }

    /** @test */
    public function it_can_cancel_itself_and_release_any_space_associated()
    {
        [$order, $space] = $this->placeOrder();

        $this->assertFalse($space->isAvailable());

        $order->delete();

        $this->assertTrue($space->isAvailable());
        $this->assertDatabaseMissing('orders', $this->orderDetails());
    }

    /**
     * Place order for a space.
     *
     * @return array
     */
    protected function placeOrder(): array
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $chargesCalculator = new Calculator($space);
        $chargesCalculator->calculateCharges();
        $order = $space->placeOrder($this->orderDetails());

        return [$order, $space];
    }

    /**
     * Get fake order details.
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function orderDetails(array $attributes = []): array
    {
        return [
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ];
    }
}
