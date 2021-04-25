<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Fixtures\PaymentTokenStub;
use App\Billing\PaymentTokens\PaymentToken;
use App\Models\PaymentToken as PaymentTokenStore;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation()
    {
        $paymentToken = new PaymentTokenStub(new PaymentTokenStore());

        $this->assertInstanceOf(PaymentToken::class, $paymentToken);
    }

    public function testGetPaymentTokenUsingTokenCode()
    {
        $paymentToken = new PaymentTokenStub(new PaymentTokenStore());
        $token = PaymentTokenStore::create([
            'name' => 'Test Token',
            'token' => Str::random(40),
        ]);

        $this->assertTrue($token->is($paymentToken->getToken($token->token)));
        $this->assertNull($paymentToken->getToken('LUSDGO7W8RGP8Q728DHQW'));
    }
}
