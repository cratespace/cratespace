<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Models\Charge;

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

        $order->cancel();

        $this->assertTrue($space->refresh()->isAvailable());
        $this->assertDatabaseMissing('orders', $this->orderDetails());
    }

    /** @test */
    public function it_can_save_charge_details()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());
        $chargeDetails = $order->saveChargeDetails([
            'amount' => $order->total,
            'card_last_four' => '4242',
            'details' => 'local',
        ]);

        $this->assertNotNull($order->charge);
        $this->assertInstanceOf(Charge::class, $order->charge);
        $this->assertDatabaseHas('charges', [
            'amount' => $order->total,
            'card_last_four' => '4242',
            'details' => json_encode('local'),
        ]);
    }

    /**
     * Place order for a space.
     *
     * @return array
     */
    protected function placeOrder(): array
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        return [$order, $space];
    }
}
