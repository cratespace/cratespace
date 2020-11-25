<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Models\Charge;
use App\Billing\PaymentGateways\FakePaymentGateway;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FakePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    /**
     * Bind payment gateway to service container.
     */
    protected function getPaymentGateway()
    {
        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /**
     * Get last charge details from Stripe.
     *
     * @param \App\models\Order $order
     * @param null              $chargeDetails
     *
     * @return \Stripe\Charge
     */
    protected function getLastCharge(Order $order, $chargeDetails = null)
    {
        return Charge::where('order_id', $order->id)->first();
    }

    /** @test */
    public function It_can_run_a_hook_before_the_first_charge()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $paymentGateway = new FakePaymentGateway();
        $timesCallbackRan = 0;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan, $space) {
            try {
                $this->calculateCharges($space);
                $firstOrder = $this->createNewOrder($space);
                $paymentGateway->charge($firstOrder, $paymentGateway->generateToken($this->getCardDetails()));
            } catch (HttpException $e) {
                ++$timesCallbackRan;
                $this->assertEquals(0, $paymentGateway->total());

                return;
            }
        });

        $this->calculateCharges($space);
        $secondOrder = $this->createNewOrder($space);
        $paymentGateway->charge($secondOrder, $paymentGateway->generateToken($this->getCardDetails()));
        $this->assertEquals(1, $timesCallbackRan);
        $this->assertEquals($secondOrder->total, $paymentGateway->total());
    }
}
