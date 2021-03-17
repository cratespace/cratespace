<?php

namespace Tests\Unit\Billing;

use Mockery as m;
use App\Billing\Stripe\Client;
use PHPUnit\Framework\TestCase;
use App\Billing\Gateways\Gateway;
use Stripe\StripeClientInterface;
use App\Billing\Gateways\StripeGateway;

class StripeGatewayTest extends TestCase
{
    public function testHasClient()
    {
        $paymentGateway = $this->getPaymentGateway();

        $this->assertInstanceOf(Gateway::class, $paymentGateway);
        $this->assertInstanceOf(Client::class, $paymentGateway->client());
    }

    /**
     * Get instance of Stripe payment gateway.
     *
     * @return \App\Billing\Gateways\Gateway
     */
    protected function getPaymentGateway(): Gateway
    {
        $client = new Client(
            m::mock(StripeClientInterface::class)
        );

        return new StripeGateway($client);
    }
}
