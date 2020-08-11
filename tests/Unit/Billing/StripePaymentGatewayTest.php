<?php

namespace Tests\Unit\Billing;

use Stripe\Token;
use Tests\TestCase;
use App\Models\Space;
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

    /**
     * Generate test stripe payment token.
     *
     * @return string
     */
    protected function generateToken(): string
    {
        return Token::create($this->getCardDetails());
    }
}
