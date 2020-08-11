<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Space;
use App\Billing\PaymentGateways\FakePaymentGateway;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FakePaymentGatewayTest extends TestCase
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
    public function it_can_generate_and_validate_a_testing_payment_token()
    {
        $paymentGateway = new FakePaymentGateway();

        $token = $paymentGateway->generateToken($this->getCardDetails());

        $this->assertTrue($paymentGateway->matches($token));
    }

    /** @test */
    public function It_can_run_a_hook_before_the_first_charge()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $paymentGateway = new FakePaymentGateway();
        $timesCallbackRan = 0;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan, $space) {
            try {
                $this->calculateCharges($space);
                $firstOrder = $space->placeOrder($this->orderDetails());
                $paymentGateway->charge($firstOrder, $paymentGateway->generateToken($this->getCardDetails()));
            } catch (HttpException $e) {
                ++$timesCallbackRan;
                $this->assertEquals(0, $paymentGateway->total());

                return;
            }
        });

        $this->calculateCharges($space);
        $secondOrder = $space->placeOrder($this->orderDetails());
        $paymentGateway->charge($secondOrder, $paymentGateway->generateToken($this->getCardDetails()));
        $this->assertEquals(1, $timesCallbackRan);
        $this->assertEquals($secondOrder->total, $paymentGateway->total());
    }
}
