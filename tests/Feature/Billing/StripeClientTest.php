<?php

namespace Tests\Feature\Billing;

use Tests\TestCase;
use Tests\Concerns\HasBillingClient;
use App\Contracts\Billing\Client as ClientContract;

class StripeClientTest extends TestCase
{
    use HasBillingClient;

    public function testInstancetiation()
    {
        $client = $this->getClient();

        $this->assertInstanceOf(ClientContract::class, $client);
    }
}
