<?php

namespace Tests\Unit\Billing;

use Exception;
use Tests\TestCase;
use App\Models\Space;
use App\Models\Charge;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use Stripe\Charge as StripeCharge;
use App\Exceptions\PaymentFailedException;
use App\Billing\PaymentGateways\StripePaymentGateway;

/**
 * @group network
 */
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
        if (!$this->isConnected()) {
            $this->markTestSkipped('An Internet connection is not available.');
        }

        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        $charge = (object) Charge::where('order_id', $order->id)->first()->details;

        $lastCharge = StripeCharge::retrieve(
            $charge->id,
            ['api_key' => env('STRIPE_SECRET_KEY')],
        );

        $this->assertEquals(3583, $this->paymentGateway->total());
        $this->assertEquals(3583, $lastCharge->amount);
        $this->assertEquals($charge->amount, $lastCharge->amount);
        $this->assertEquals($order->total, $lastCharge->amount);
        $this->assertDatabaseHas('charges', ['amount' => $order->total]);
    }

    /** @test */
    public function it_can_generate_a_valid_payment_token_and_validate_it()
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
        $order = $space->placeOrder($this->orderDetails());

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
