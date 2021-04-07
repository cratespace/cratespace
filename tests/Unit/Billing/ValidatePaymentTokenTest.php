<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\PaymentToken;
use Tests\Fixtures\MockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;
use App\Billing\PaymentTokens\ValidatePaymentToken;

class ValidatePaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentTokenValidation()
    {
        $product = new MockProduct('test_product');
        $store = new PaymentToken();
        $generator = new GeneratePaymentToken($store);
        $validator = new ValidatePaymentToken($store);

        $token = $generator->generate($product);

        $this->assertTrue($validator->validate($token));
        $this->assertFalse($validator->validate('FO783WGEWD7EWYOS8Q2HESIAW'));
    }
}
