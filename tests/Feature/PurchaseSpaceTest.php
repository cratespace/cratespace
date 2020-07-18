<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use App\Billing\FakePaymentGateway;
use App\Contracts\Billing\PaymentGateway;

class PurchaseSpaceTest extends TestCase
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\FakePaymentGateway
     */
    protected $paymentGateway;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function a_customer_can_purchase_a_space()
    {
        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->postJson("/spaces/{$space->uid}/orders", [
            'email' => 'john@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);
        $this->assertEquals(3250, $this->paymentGateway->totalCharges());
        $this->assertNotNull($space->order);
        $this->assertEquals('john@example.com', $space->order->email);
    }

    /** @test */
    public function an_email_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->postJson("/spaces/{$space->uid}/orders", [
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422)->assertSessionMissing('email');
    }
}
