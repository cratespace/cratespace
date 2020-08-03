<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Stripe\Token as StripeTokenGenerator;
use App\Billing\PaymentGateways\StripePaymentGateway;

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
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => date('Y') + 1,
                'cvc' => '123',
            ],
        ], ['api_key' => $apiKey]);

        return $tokenObject->id;
    }
}
