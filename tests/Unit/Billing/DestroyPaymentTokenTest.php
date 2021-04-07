<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\PaymentToken;
use Tests\Fixtures\MockProduct;
use App\Billing\PaymentTokens\DestroyPaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;

class DestroyPaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentTokenValidation()
    {
        $product = new MockProduct('test_product');
        $store = new PaymentToken();
        $generator = new GeneratePaymentToken($store);
        $destroyer = new DestroyPaymentToken($store);

        $token = $generator->generate($product);

        $this->assertDatabaseHas('payment_tokens', ['token' => $token]);

        $destroyer->destroy($token);

        $this->assertDatabaseMissing('payment_tokens', ['token' => $token]);
    }
}
