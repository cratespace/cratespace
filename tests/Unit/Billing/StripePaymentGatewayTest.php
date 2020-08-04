<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use ReflectionClass;
use App\Billing\Charge;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiKey = config('services.stripe.secret');

        $this->performFirstCharge();
    }

    /** @test */
    public function it_can_create_instance_of_stripe_api_client()
    {
        $stripePaymentGateway = new StripePaymentGateway($this->apiKey);

        $stripeReflection = new ReflectionClass($stripePaymentGateway);
        $getStripeProperty = $stripeReflection->getMethod('makeStripeClient');
        $getStripeProperty->setAccessible(true);

        $this->assertInstanceOf(StripeClient::class, $getStripeProperty->invoke($stripePaymentGateway));
    }

    /** @test */
    public function it_can_create_instance_of_stripe_charger()
    {
        $stripePaymentGateway = new StripePaymentGateway($this->apiKey);

        $stripeReflection = new ReflectionClass($stripePaymentGateway);
        $getStripeProperty = $stripeReflection->getMethod('getStripeCharger');
        $getStripeProperty->setAccessible(true);

        $this->assertInstanceOf(ChargeService::class, $getStripeProperty->invoke($stripePaymentGateway));
    }

    /** @test */
    public function it_can_create_instance_of_local_charger()
    {
        $stripePaymentGateway = new StripePaymentGateway($this->apiKey);

        $stripeReflection = new ReflectionClass($stripePaymentGateway);
        $getStripeProperty = $stripeReflection->getMethod('getLocalCharger');
        $getStripeProperty->setAccessible(true);

        $this->assertInstanceOf(
            Charge::class,
            $getStripeProperty->invokeArgs(
                $stripePaymentGateway,
                [$this->getCardDetails()]
            )
        );
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
    protected function generateTestStripeToken(?string $apiKey = null): string
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
            'number' => $this->getPaymentGateway()::TEST_CARD_NUMBER,
            'exp_month' => 1,
            'exp_year' => date('Y') + 1,
            'cvc' => '123',
        ];
    }
}
