<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\PaymentToken;
use Tests\Fixtures\ProductStub;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;

class GeneratePaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testGeneratePaymentToken()
    {
        $product = new ProductStub('test_product');
        $product->setCode(Str::random(40));
        $generator = new GeneratePaymentToken(new PaymentToken());

        $token = $generator->generate($product);

        $this->assertTrue(Hash::check($product->code(), $token));
    }
}
