<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use App\Billing\FakePaymentGateway;
use App\Contracts\Billing\PaymentGateway;

class PurchaseSpaceTest extends TestCase
{
    /** @test */
    public function a_customer_can_purchase_a_space()
    {
        $this->withoutExceptionHandling();

        $paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->postJson("/spaces/{$space->uid}/orders", [
            'email' => 'john@example.com',
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);
        $this->assertEquals(3250, $paymentGateway->totalCharges());
        $this->assertNotNull($space->order);
        $this->assertEquals('john@example.com', $space->order->email);
    }
}
