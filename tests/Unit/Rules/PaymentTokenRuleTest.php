<?php

namespace Tests\Unit\Rules;

use Mockery as m;
use Illuminate\Support\Str;
use App\Rules\PaymentTokenRule;
use PHPUnit\Framework\TestCase;
use App\Billing\PaymentTokens\ValidatePaymentToken;

class PaymentTokenRuleTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testValidatePaymentToken()
    {
        $token = Str::random(40);
        $validator = m::mock(ValidatePaymentToken::class);
        $validator->shouldReceive('validate')
            ->once()
            ->with($token)
            ->andReturn(true);
        $rule = new PaymentTokenRule($validator);

        $this->assertTrue($rule->passes('payment_token', $token));
    }

    public function testErrorMessage()
    {
        $validator = m::mock(ValidatePaymentToken::class);
        $validator->shouldReceive('validate')
            ->once()
            ->with($token = Str::random(40))
            ->andReturn(false);
        $rule = new PaymentTokenRule($validator);

        $this->assertFalse($rule->passes('payment_token', $token));
        $this->assertEquals('This payment token is invalid.', $rule->message());
    }
}
