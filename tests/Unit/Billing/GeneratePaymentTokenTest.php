<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\PaymentToken;
use Tests\Fixtures\MockProduct;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;

class GeneratePaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testGeneratePaymentToken()
    {
        $product = new MockProduct('test_product');
        $generator = new GeneratePaymentToken(new PaymentToken());

        $token = $generator->generate($product);

        $this->assertTrue(Hash::check($product->code(), $token));
    }
}
