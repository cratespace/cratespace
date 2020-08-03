<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Stripe\Token as StripeTokenGenerator;
use App\Billing\PaymentGateways\StripePaymentGateway;

class StripePaymentGatewayTest extends TestCase
{
    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $apiKey = config('services.stripe.secret');

        $paymentGatewayFirst = new StripePaymentGateway($apiKey);

        $paymentGatewayFirst->charge(2400, $this->generateStripeToken($apiKey));

        $firstChargeId = $paymentGatewayFirst->charges()->last()->id;

        $paymentGatewayLast = new StripePaymentGateway($apiKey);

        $paymentGatewayLast->charge(2500, $this->generateStripeToken($apiKey));

        $this->assertCount(1, $paymentGatewayLast->newChargesSince($firstChargeId));
        $this->assertEquals(2500, $paymentGatewayLast->newChargesSince($firstChargeId)->last()->amount);
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
