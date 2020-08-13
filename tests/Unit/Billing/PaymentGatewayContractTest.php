<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Space;
use App\Events\OrderPlaced;
use App\Events\SuccessfullyCharged;
use Illuminate\Support\Facades\Event;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class PaymentGatewayContractTest extends TestCase
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\PaymentGateways\StripePaymentGateway
     */
    protected $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('defaults.charges.service', 0.03);
        config()->set('defaults.charges.tax', 0.01);

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function it_fires_an_event_after_a_successfull_charge()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        Event::fake();

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        Event::assertDispatched(function (SuccessfullyCharged $event) use ($order) {
            return $event->order->id === $order->id;
        });

        Event::assertDispatched(function (OrderPlaced $event) use ($order) {
            return $event->order->id === $order->id;
        });
    }
}
