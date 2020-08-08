<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Event;

class OrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('defaults.charges', [
            'service' => 0.03,
            'tax' => 0.01,
        ]);
    }

    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function it_can_calculate_total_amount_and_present_in_currency_format()
    {
        [$order, $space] = $this->placeOrder();

        $this->assertEquals(3583, $order->total);
    }

    /** @test */
    public function it_can_caluculate_charges_dynamically()
    {
        [$order, $space] = $this->placeOrder();

        $this->assertEquals(3250, $order->price);
        $this->assertEquals(69.26, $order->tax);
        $this->assertEquals(102.36, $order->service);
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

    /** @test */
    public function it_can_fire_an_event_every_time_its_status_is_updated()
    {
        $this->signIn();

        [$order, $space] = $this->placeOrder();

        Event::fake();

        $order->updateStatus('Approved');

        Event::assertDispatched(function (OrderStatusUpdated $event) use ($order) {
            return $event->getOrder()->id === $order->id &&
                $event->getOrder()->status === $order->status &&
                $event->getOrder()->status === 'Approved';
        });

        $this->assertEquals('Approved', $order->fresh()->status);
    }

    /**
     * Place order for a space.
     *
     * @return array
     */
    protected function placeOrder(): array
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
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
