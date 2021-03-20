<?php

namespace Tests\Unit\Stripe;

use Tests\TestCase;
use App\Services\Stripe\Client;
use Stripe\Service\RefundService;
use Stripe\StripeClientInterface;
use Stripe\Service\CustomerService;
use Stripe\Service\PaymentIntentService;
use Stripe\Service\PaymentMethodService;

class ClientTest extends TestCase
{
    public function testMakeInstance()
    {
        $client = Client::make();

        $this->assertInstanceOf(StripeClientInterface::class, $client);
    }

    public function testGetApiKey()
    {
        $client = Client::make();

        $this->assertEquals(config('billing.secret'), $client->getApiKey());
    }

    public function testDynamicallyGetProperty()
    {
        $this->assertInstanceOf(PaymentIntentService::class, Client::paymentIntents());
        $this->assertInstanceOf(CustomerService::class, Client::customers());
        $this->assertInstanceOf(RefundService::class, Client::refunds());
        $this->assertInstanceOf(PaymentMethodService::class, Client::paymentMethods());
    }
}
