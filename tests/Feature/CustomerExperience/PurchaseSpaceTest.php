<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Pipeline\Pipeline;
use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class PurchaseSpaceTest extends TestCase
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\PaymentGateways\FakePaymentGateway
     */
    protected $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway('base64:gKVpXFjfCb8kwMwLw68XyIb8+0phfkQkXsE/GCt2VFc=');
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);

        config()->set('defaults.billing.charges.services', 0.03); // 3% service charge
    }

    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function a_customer_can_purchase_a_space()
    {
        $this->withoutExceptionHandling();

        $space = create(Space::class, ['price' => 32.50, 'tax' => 0.5]);

        $this->calculateCharges($space);

        $this->postJson("/spaces/{$space->uid}/orders", $this->orderDetails());

        $this->assertEquals(3465, $this->paymentGateway->total());
        $this->assertNotNull($space->order);
        $this->assertFalse($space->isAvailable());
        // $this->assertEquals('Ordered', $space->refresh()->status);
        $this->assertEquals('john@example.com', $space->order->email);
    }

    /**
     * Get fake order details.
     *
     * @param array $extraAttributes
     *
     * @return array
     */
    protected function orderDetails(array $extraAttributes = []): array
    {
        return array_merge([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
            'payment_token' => '',
            'card_number' => '4242424242424242',
        ], $extraAttributes);
    }

    /**
     * Get charges calculator instacne and calculate required charges.
     *
     * @param \App\Contracts\Models\Priceable $space
     *
     * @return void
     */
    protected function calculateCharges(Priceable $space): void
    {
        $chargesCalculator = new Calculator(new Pipeline(app()), $space);

        $chargesCalculator->calculate();
    }
}
