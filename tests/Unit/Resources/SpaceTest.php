<?php

namespace Tests\Unit\Resources;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use Illuminate\Pipeline\Pipeline;
use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use App\Models\Values\ScheduleValue;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SpaceTest extends TestCase
{
    /** @test */
    public function it_has_a_set_of_required_attributes()
    {
        $space = create(Space::class);

        $this->assertDatabaseHas('spaces', [
            'uid' => $space->uid,
            'departs_at' => $space->departs_at,
            'arrives_at' => $space->arrives_at,
            'origin' => $space->origin,
            'destination' => $space->destination,
            'height' => $space->height,
            'width' => $space->width,
            'length' => $space->length,
            'weight' => $space->weight,
            'price' => $space->price,
            'tax' => $space->tax,
            'user_id' => $space->user_id,
            'type' => $space->type,
        ]);
    }

    /** @test */
    public function it_can_cast_departure_and_arrival_dates_as_carbon_instances()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(Carbon::class, $space->departs_at);
        $this->assertInstanceOf(Carbon::class, $space->arrives_at);
        $this->assertInstanceOf(ScheduleValue::class, $space->schedule);
    }

    /** @test */
    public function it_can_create_a_schedule_value_object_of_given_dates()
    {
        $space = create(Space::class);

        $this->assertEquals($space->departs_at->format('M j, Y g:ia'), $space->schedule->departsAt);
        $this->assertEquals($space->arrives_at->format('M j, Y g:ia'), $space->schedule->arrivesAt);
    }

    /** @test */
    public function it_belongs_to_a_business_user()
    {
        $user = create(User::class);
        $space = create(Space::class, ['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $space->user);
        $this->assertEquals($user->id, $space->user->id);
    }

    /** @test */
    public function it_can_place_an_order_for_itself()
    {
        $space = create(Space::class);
        $this->calculateCharges($space);
        $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertNotNull($space->order);
        $this->assertInstanceOf(Order::class, $space->order);
        $this->assertEquals('john@example.com', $space->order->email);
    }

    /** @test */
    public function it_can_place_an_order_for_itself_only_if_it_is_available()
    {
        $this->expectException(HttpException::class);

        $orderedSpace = create(Space::class);
        $this->calculateCharges($orderedSpace);
        $orderedSpace->placeOrder(make(Order::class)->toArray());

        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $expiredSpace->placeOrder(make(Order::class)->toArray());
    }

    /**
     * Calculate charges using given resource.
     *
     * @param \App\Contracts\Models\Priceable $resource
     *
     * @return void
     */
    protected function calculateCharges(Priceable $resource)
    {
        $this->getCalculator($resource)->calculate();
    }

    /**
     * Get charge calculator instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return \App\Contracts\Support\Calculator
     */
    public function getCalculator(Model $resource): Calculator
    {
        return new Calculator($this->getPipeline(), $resource);
    }

    /**
     * Get Laravel pipeline instance.
     *
     * @return \Illuminate\Contracts\Pipeline\Pipeline
     */
    public function getPipeline(): Pipeline
    {
        return app()->make(Pipeline::class);
    }
}
