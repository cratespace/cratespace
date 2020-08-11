<?php

namespace Tests\Unit\Billing;

use Stripe\Token;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use Stripe\Charge as StripeCharge;
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

    // protected function getCharges()
    // {
    //     StripeCharge::all()
    // }

    /**
     * Generate test stripe payment token.
     *
     * @return string
     */
    protected function generateToken(): string
    {
        return Token::create($this->getCardDetails());
    }

    /**
     * Fake a json post request to purchase/order a space.
     *
     * @param \App\Models\Space $space
     * @param array             $parameters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function orderSpace(Space $space, array $parameters = [])
    {
        $this->calculateCharges($space);

        return $this->postJson("/spaces/{$space->uid}/orders", $parameters);
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
        return array_merge([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ], $attributes);
    }

    /**
     * Get fake credit card details.
     *
     * @return array
     */
    protected function getCardDetails(): array
    {
        return [
            'number' => StripePaymentGateway::TEST_CARD_NUMBER,
            'exp_month' => 1,
            'exp_year' => date('Y') + 1,
            'cvc' => '123',
        ];
    }
}
