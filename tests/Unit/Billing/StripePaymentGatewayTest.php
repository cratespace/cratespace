<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Space;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use App\Billing\PaymentGateways\StripePaymentGateway;

class StripePaymentGatewayTest extends TestCase
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

        $this->paymentGateway = new StripePaymentGateway(env('STRIPE_SECRET_KEY'));
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function it_accepts_charges_with_a_valid_payment_token()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        $this->assertEquals(3583, $this->paymentGateway->total());
        $this->assertDatabaseHas('charges', [
            'amount' => $order->total,
        ]);
    }

    /** @test */
    public function it_can_generate_a_valid_payment_token_and_validate_it()
    {
        $token = $this->paymentGateway->generateToken($this->getCardDetails());

        $this->assertTrue($this->paymentGateway->matches($token));
    }

    /** @test */
    public function it_can_create_an_instance_of_stripe_api_client()
    {
        $this->assertInstanceOf(
            StripeClient::class,
            $this->setAccessibleMethod($this->paymentGateway, 'createStripeClient')
        );
    }

    /** @test */
    public function it_can_create_an_instance_of_stripe_charges()
    {
        $this->assertInstanceOf(
            ChargeService::class,
            $this->setAccessibleMethod($this->paymentGateway, 'getStripeCharges')
        );
    }
}
