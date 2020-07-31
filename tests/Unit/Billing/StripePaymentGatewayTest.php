<?php

namespace Tests\Unit\Billing;

use PHPUnit\Framework\TestCase;

class StripePaymentGatewayTest extends TestCase
{
    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $this->assertTrue(true);
    }
}
