<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Stripe\Token as StripeTokenGenerator;
use App\Exceptions\PaymentFailedException;
use App\Billing\PaymentGateways\StripePaymentGateway;

/**
 * @group integration
 */
class StripePaymentGatewayTest extends TestCase
{
    /**
     * Stripe test secret key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * ID of latest charge made.
     *
     * @var string
     */
    protected $lastChargeId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiKey = config('services.stripe.secret');

        $paymentGatewayFirst = new StripePaymentGateway($this->apiKey);

        $paymentGatewayFirst->charge(2400, $this->generateStripeToken($this->apiKey));

        $this->lastChargeId = $paymentGatewayFirst->charges()->last()->id;
    }

    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $newPaymentGateway = new StripePaymentGateway($this->apiKey);

        $newPaymentGateway->charge(2500, $this->generateStripeToken($this->apiKey));

        $this->assertCount(1, $newPaymentGateway->newChargesSince($this->lastChargeId));
        $this->assertEquals(2500, $newPaymentGateway->newChargesSince($this->lastChargeId)->last()->amount);
    }

    /** @test */
    public function charges_with_an_invalid_payment_token_fail()
    {
        try {
            $paymentGateway = new StripePaymentGateway($this->apiKey);
            $paymentGateway->charge(2500, 'invalid-payment-token');
        } catch (PaymentFailedException $e) {
            $this->assertEquals(2500, $e->chargedAmount());
            $this->assertInstanceOf(PaymentFailedException::class, $e);
            $this->assertCount(0, $paymentGateway->newChargesSince($this->lastChargeId));

            return;
        }

        $this->fail('Charging with an invalid payment token did not throw an PaymentFailedException.');
    }

    /** @test */
    public function It_can_run_a_hook_before_the_first_charge()
    {
        $paymentGateway = new StripePaymentGateway($this->apiKey);
        $timesCallbackRan = 0;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan) {
            $paymentGateway->charge(1200, $paymentGateway->generateToken($this->getCardDetails()));

            ++$timesCallbackRan;

            $this->assertEquals(1200, $paymentGateway->totalCharges());
        });

        $paymentGateway->charge(
            1200,
            $paymentGateway->generateToken($this->getCardDetails())
        );
        $this->assertEquals(1, $timesCallbackRan);
        $this->assertEquals(2400, $paymentGateway->totalCharges());
    }

    /**
     * Generate valid stripe token.
     *
     * @param string $apiKey
     *
     * @return string
     */
    protected function generateStripeToken(string $apiKey)
    {
        $tokenObject = StripeTokenGenerator::create([
            'card' => $this->getCardDetails(),
        ], ['api_key' => $apiKey]);

        return $tokenObject->id;
    }

    /**
     * Get test credit card details.
     *
     * @return array
     */
    protected function getCardDetails(): array
    {
        return [
            'number' => '4242424242424242',
            'exp_month' => 1,
            'exp_year' => date('Y') + 1,
            'cvc' => '123',
        ];
    }
}
