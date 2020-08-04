<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Billing\Calculator;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Event;

class OrderTest extends TestCase
{
    protected function tearDown(): void
    {
        cache()->flush();
    }

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

    /** @test */
    public function it_has_default_of_pending_status()
    {
        $order = create(Order::class);

        $this->assertEquals('Pending', $order->status);
    }

    /** @test */
    public function it_can_update_status_marks()
    {
        $order = create(Order::class);

        $this->assertEquals('Pending', $order->status);

        $order->updateStatus('Completed');

        $this->assertEquals('Completed', $order->refresh()->status);
    }

    /** @test */
    public function it_can_perform_fuzzy_search_on_itself()
    {
        create(Order::class, [], 10);
        $orderByThavarshan = create(Order::class, ['name' => 'Thavarshan']);
        $orderThatShouldNotBeFound = create(Order::class, ['name' => 'NotFound']);

        $searchResults = Order::search('thav')->get();

        $this->assertTrue($searchResults->contains($orderByThavarshan));
        $this->assertFalse($searchResults->contains($orderThatShouldNotBeFound));
    }

    /** @test */
    public function it_can_get_orders_that_belong_to_a_specific_business()
    {
        $user = $this->signIn();

        $extrenalOrders = create(Order::class, ['user_id' => 999], 10);
        $businessOrders = create(Order::class, ['user_id' => $user->id], 10);

        $orderFilter = new OrderFilter(Request::create('/', 'GET'));
        $orders = Order::ForBusiness($orderFilter)->get();

        foreach ($extrenalOrders as $extrenalOrder) {
            $this->assertFalse($orders->contains($extrenalOrder));
        }

        foreach ($businessOrders as $businessOrder) {
            $this->assertTrue($orders->contains($businessOrder));
        }
    }

    /** @test */
    public function it_can_fire_an_event_every_time_its_status_is_updated()
    {
        Event::fake();

        $order = create(Order::class);

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
