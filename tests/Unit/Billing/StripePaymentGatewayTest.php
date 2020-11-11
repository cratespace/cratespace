<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Charge;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use Stripe\Charge as StripeCharge;
use App\Billing\PaymentGateways\StripePaymentGateway;

/**
 * @group network
 */
class StripePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    /**
     * Bind payment gateway to service container.
     */
    protected function getPaymentGateway()
    {
        if (! env('STRIPE_SECRET_KEY')) {
            $this->markTestSkipped('Stripe secret key not set.');
        }

        $this->paymentGateway = new StripePaymentGateway(env('STRIPE_SECRET_KEY'));
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /**
     * Get last charge details from Stripe.
     *
     * @param \App\models\Order $order
     * @param null              $chargeDetails
     *
     * @return \Stripe\Charge
     */
    protected function getLastCharge(Order $order, $chargeDetails = null)
    {
        return StripeCharge::retrieve(
            $chargeDetails->id,
            ['api_key' => env('STRIPE_SECRET_KEY')],
        );
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
