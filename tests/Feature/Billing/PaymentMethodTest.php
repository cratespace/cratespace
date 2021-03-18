<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use Tests\Concerns\HasBillingClient;

class PaymentMethodTest extends TestCase
{
    use HasBillingClient;

    public function testCreateAndGetPaymentMethod()
    {
        $client = $this->getClient();
        $paymentMethod = $client->createMethod([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 3,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ]);

        $this->assertEquals(
            $paymentMethod->type,
            $client->getMethod($paymentMethod->id)->type
        );
    }
}
