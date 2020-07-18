<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use App\Billing\FakePaymentGateway;
use Illuminate\Testing\TestResponse;
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

        $response = $this->orderSpace($space, [
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

        $response = $this->orderSpace($space, [
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function an_valid_email_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->orderSpace($space, [
            'email' => 'not-an-email-address',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function an_valid_payment_token_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->orderSpace($space, [
            'email' => 'john@example.com',
        ]);

        $this->assertValidationError($response, 'payment_token');
    }

    /** @test */
    public function an_order_is_not_created_if_the_payment_failed()
    {
        $space = create(Space::class, ['price' => 32.50]);

        $response = $this->orderSpace($space, [
            'email' => 'john@example.com',
            'payment_token' => 'invalid-payment-token',
        ]);

        $response->assertStatus(422);
        $this->assertNull($space->order);
    }

    /** @test */
    public function cannot_purchase_an_expired_or_ordered_space()
    {
        $expiredSpace = create(Space::class, ['status' => 'Expired']);
        $orderedSpace = create(Space::class, ['status' => 'Ordered']);

        $response = $this->orderSpace($expiredSpace, [
            'email' => 'john@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        // The request will only be authorized if the space status is
        // marked as "Available". This is don on the authorization
        // method of "PlaceOrderRequest::class"
        $response->assertStatus(403);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());

        $response = $this->orderSpace($orderedSpace, [
            'email' => 'john@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(403);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /**
     * Fake a json post request to purchase/order a space.
     *
     * @param \App\Models\Space $space
     * @param array             $parameters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function orderSpace(Space $space, array $parameters = [])
    {
        return $this->postJson("/spaces/{$space->uid}/orders", $parameters);
    }

    /**
     * Assert that a validation exception is thrown.
     *
     * @param \Illuminate\Testing\TestResponse $response
     * @param string                           $key
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function assertValidationError(TestResponse $response, string $key)
    {
        return $response->assertStatus(422)->assertSessionMissing($key);
    }
}
