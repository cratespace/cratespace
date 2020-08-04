<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Stripe\Token as StripeTokenGenerator;
use App\Billing\PaymentGateways\StripePaymentGateway;

/**
 * @group integration
 */
class StripePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

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

        $this->performFirstCharge();
    }

    /** @test */
    public function charges_with_a_valid_payment_token_are_successful_stripe()
    {
        $newPaymentGateway = $this->getPaymentGateway();

        $newPaymentGateway->charge(2500, $this->generateToken());

        $this->assertCount(1, $newPaymentGateway->newChargesSince($this->lastChargeId));
        $this->assertEquals(2500, $newPaymentGateway->totalCharges());
    }

    /**
     * Get instance of payment gateway.
     *
     * @return \App\Contracts\Billing\PaymentGateway
     */
    protected function getPaymentGateway()
    {
        return new StripePaymentGateway($this->apiKey);
    }

    /**
     * Generate valid payment token.
     *
     * @param string|null $apiKey
     *
     * @return string
     */
    protected function generateToken(?string $apiKey = null): string
    {
        $tokenObject = StripeTokenGenerator::create([
            'card' => $this->getCardDetails(),
        ], ['api_key' => $apiKey ?? $this->apiKey]);

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
