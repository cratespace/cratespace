<?php

namespace Tests\Unit\Stripe;

use Tests\TestCase;
use App\Facades\Stripe;
use Stripe\Util\LoggerInterface;
use Stripe\Service\RefundService;
use Stripe\StripeClientInterface;
use Stripe\Service\CustomerService;
use Stripe\Service\PaymentIntentService;
use Stripe\Service\PaymentMethodService;

/**
 * @group Stripe
 */
class ClientTest extends TestCase
{
    public function testMakeInstance()
    {
        $client = Stripe::make();

        $this->assertInstanceOf(StripeClientInterface::class, $client);
    }

    public function testGetApiKey()
    {
        $client = Stripe::make();

        $this->assertEquals(
            config('billing.services.stripe.secret'),
            $client->getApiKey()
        );
    }

    public function testStripeLoggerInstance()
    {
        $this->assertInstanceOf(LoggerInterface::class, Stripe::logger());
    }

    public function testDynamicallyGetProperty()
    {
        $this->assertInstanceOf(PaymentIntentService::class, Stripe::paymentIntents());
        $this->assertInstanceOf(CustomerService::class, Stripe::customers());
        $this->assertInstanceOf(RefundService::class, Stripe::refunds());
        $this->assertInstanceOf(PaymentMethodService::class, Stripe::paymentMethods());
    }
}
