<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class ViewOrderTest extends TestCase
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\PaymentGateways\FakePaymentGateway
     */
    protected $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function a_customer_can_view_their_order_confirmation()
    {
        $space = create(Space::class);

        $this->get("/spaces/{$space->uid}/checkout")->assertStatus(200);

        $this->post("/spaces/{$space->uid}/orders", [
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $order = Order::whereSpaceId($space->id)->firstOrFail();

        $this->get("/orders/{$order->confirmation_number}")
            ->assertStatus(200)
            ->assertSee($order->uid)
            ->assertSee($order->name)
            ->assertSee($order->email)
            ->assertSee($order->phone)
            ->assertSee($order->total)
            ->assertSee($order->created_at)
            ->assertSee($space->uid)
            ->assertSee($space->origin)
            ->assertSee($space->destination)
            ->assertSee($space->departs_at)
            ->assertSee($space->arrives_at);
    }
}
