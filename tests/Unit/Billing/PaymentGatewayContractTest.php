<?php

namespace Tests\Unit\Billing;

use Exception;
use App\Models\Space;
use App\Models\Charge;
use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Event;
use App\Events\SuccessfullyChargedEvent;
use App\Exceptions\PaymentFailedException;

trait PaymentGatewayContractTest
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\PaymentGateways\PaymentGateway
     */
    protected $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->determineNetworkConnectionForStripeTests();

        config()->set('defaults.charges.service', 0.03);
        config()->set('defaults.charges.tax', 0.01);

        $this->getPaymentGateway();
    }

    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function it_fires_an_event_after_a_successfull_charge()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
        $order = $this->createNewOrder($space);

        Event::fake();

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        Event::assertDispatched(function (SuccessfullyChargedEvent $event) use ($order) {
            return $event->order->id === $order->id;
        });

        Event::assertDispatched(function (OrderPlacedEvent $event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    /** @test */
    public function it_accepts_charges_with_a_valid_payment_token()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $this->createNewOrder($space);

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        $charge = (object) Charge::where('order_id', $order->id)->first()->details;

        $lastCharge = $this->getLastCharge($order, $charge);

        $this->assertEquals(3583, $this->paymentGateway->total());
        $this->assertEquals(3583, $lastCharge->amount);
        $this->assertEquals($order->total, $lastCharge->amount);
        $this->assertDatabaseHas('charges', ['amount' => $order->total]);
    }

    /** @test */
    public function it_can_generate_and_validate_a_testing_payment_token()
    {
        $token = $this->paymentGateway->generateToken($this->getCardDetails());

        $this->assertTrue($this->paymentGateway->matches($token));
    }

    /** @test */
    public function it_rejects_charges_with_an_invalid_payment_token()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $this->createNewOrder($space);

        try {
            $this->paymentGateway->charge($order, 'invalid-payment-token');
        } catch (Exception $e) {
            $this->assertInstanceOf(PaymentFailedException::class, $e);
            $this->assertEquals(3583, $e->chargedAmount());
            $this->assertEquals(0, $this->paymentGateway->total());
            $this->assertDatabaseMissing('charges', [
                'amount' => $order->total,
            ]);

            return true;
        }

        $this->fail();
    }

    /**
     * Skip stripe integration tests if no network connection is detected.
     *
     * @return void
     */
    protected function determineNetworkConnectionForStripeTests(): void
    {
        if (! $this->isConnected() && class_basename($this) === 'StripePaymentGatewayTest') {
            $this->markTestSkipped('An Internet connection is not available.');
        }
    }
}
