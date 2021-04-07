<?php

namespace Tests\Unit\Rules;

use Tests\TestCase;
use App\Rules\PaymentMethodRule;
use App\Services\Stripe\PaymentMethod;

/**
 * @group Stripe
 */
class PaymentMethodRuleTest extends TestCase
{
    public function testValidateTestPaymentMethod()
    {
        $rule = new PaymentMethodRule();

        $this->assertTrue($rule->passes('payment_method', 'pm_card_visa'));
    }

    public function testValidateActualPaymentMethod()
    {
        $rule = new PaymentMethodRule();
        $paymentMethod = PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 4,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ]);

        $this->assertTrue($rule->passes('payment_method', $paymentMethod->id));
    }

    public function testErrorMessage()
    {
        $rule = new PaymentMethodRule();

        $this->assertFalse($rule->passes('payment_method', 'money'));
        $this->assertEquals('The payment method provided is invalid.', $rule->message());
    }
}
