<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Space;
use App\Models\Charge;
use Illuminate\Support\Str;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Contracts\Support\Validator as ValidatorContract;

class BasePaymentGatewayTest extends TestCase
{
    /** @test */
    public function it_can_save_charge_details()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        $paymentGateway = new MockPaymentGateway();
        $token = $paymentGateway->generateToken($this->getCardDetails());
        $charge = $paymentGateway->createCharge($order, $token);

        $this->assertInstanceOf(Charge::class, $charge);
        $this->assertTrue($charge->order->is($order));
        $this->assertEquals($charge->amount, $order->total);
        $this->assertDatabaseHas('charges', ['amount' => $charge->amount]);
    }

    /** @test */
    public function it_can_validate_a_payment_token_according_to_given_validators()
    {
        $space = create(Space::class, ['price' => 3250, 'tax' => 162.5]);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());

        $paymentGateway = new MockPaymentGateway();
        $token = $paymentGateway->generateToken($this->getCardDetails());

        $this->assertTrue($paymentGateway->matches($token));
    }

    /** @test */
    public function it_can_set_a_before_hook()
    {
        $paymentGateway = new MockPaymentGateway();
        $paymentGateway->beforeFirstCharge(function ($paymentGateway) {
            return true;
        });

        $this->assertFalse(is_null($this->setAccessibleProperty($paymentGateway, 'beforeFirstChargeCallback')));
        $this->setAccessibleMethod($paymentGateway, 'runBeforeChargesCallback');
        $this->assertTrue(is_null($this->setAccessibleProperty($paymentGateway, 'beforeFirstChargeCallback')));
    }
}

class MockPaymentGateway extends PaymentGateway
{
    /**
     * Payment token validators.
     *
     * @var array
     */
    protected static $validators = [
        MockValidator::class,
    ];

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string
    {
        $token = Str::random(40);

        $this->tokens[$token] = $card['number'];

        return $token;
    }
}

class MockValidator implements ValidatorContract
{
    /**
     * Determine if the given item passes the given standards.
     *
     * @param mixed      $item
     * @param array|null $options
     *
     * @return bool
     */
    public function validate($item, ?array $options = null): bool
    {
        return true;
    }
}
