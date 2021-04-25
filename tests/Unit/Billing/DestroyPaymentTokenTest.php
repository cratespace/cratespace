<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\PaymentToken;
use Tests\Fixtures\ProductStub;
use App\Billing\PaymentTokens\DestroyPaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;

class DestroyPaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentTokenValidation()
    {
        $product = new ProductStub('test_product');
        $product->setCode(Str::random(40));
        $store = new PaymentToken();
        $generator = new GeneratePaymentToken($store);
        $destroyer = new DestroyPaymentToken($store);

        $token = $generator->generate($product);

        $this->assertDatabaseHas('payment_tokens', ['token' => $token]);

        $destroyer->destroy($token);

        $this->assertDatabaseMissing('payment_tokens', ['token' => $token]);
    }
}
