<?php

namespace Tests\Feature\CustomerExperience;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
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

        config()->set('defaults.charges.service', 0.03);
        config()->set('defaults.charges.tax', 0.01);

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function a_customer_can_purchase_a_space()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);

        $response = $this->orderSpace($space, $this->orderDetails([
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]));

        $response->assertStatus(201)->assertJson([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);
        $this->assertEquals(3583, $this->paymentGateway->total());
        $this->assertNotNull($space->order);
        $this->assertFalse($space->refresh()->isAvailable());
        $this->assertEquals('john@example.com', $space->order->email);
    }

    /** @test */
    public function an_email_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 3250]);

        $response = $this->orderSpace($space, [
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function an_valid_email_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 3250]);

        $response = $this->orderSpace($space, $this->orderDetails([
            'email' => 'invalid-email',
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]));

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function a_valid_payment_token_is_required_to_purchase_spaces()
    {
        $space = create(Space::class, ['price' => 3250]);

        $response = $this->orderSpace($space, $this->orderDetails([
            'payment_token' => 'invalid-payment-token',
        ]));

        $this->assertValidationError($response, 'payment_token');
    }

    /** @test */
    public function an_order_is_not_created_if_the_payment_failed()
    {
        $space = create(Space::class, ['price' => 3250]);

        $response = $this->orderSpace($space, $this->orderDetails([
            'payment_token' => 'invalid-payment-token',
        ]));

        $response->assertStatus(422);
        $this->assertNull($space->order);
        $this->assertTrue($space->isAvailable());
    }

    /** @test */
    public function customer_cannot_purchase_an_expired_or_ordered_space()
    {
        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $orderedSpace = create(Space::class);
        $this->calculateCharges($orderedSpace);
        $orderedSpace->placeOrder($this->orderDetails());

        $response = $this->orderSpace($expiredSpace, $this->orderDetails([
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]));

        // The request will only be authorized if the space status is
        // marked as "Available". This is don on the authorization
        // method of "PlaceOrderRequest::class"
        $response->assertStatus(403);
        $this->assertEquals(0, $this->paymentGateway->total());

        $response = $this->orderSpace($orderedSpace, $this->orderDetails([
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]));

        $response->assertStatus(403);
        $this->assertEquals(0, $this->paymentGateway->total());
    }

    /** @test */
    public function a_customer_cannot_purchase_space_another_customer_is_already_trying_to_purchase()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);

        $this->paymentGateway->beforeFirstCharge(function ($paymentGateway) use ($space) {
            $response = $this->orderSpace($space, $this->orderDetails([
                'email' => 'john.bernard@example.com',
                'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
            ]));

            $response->assertStatus(403);
            $this->assertFalse(Order::whereEmail('john.bernard@example.com')->exists());
            $this->assertEquals(0, $this->paymentGateway->total());
        });

        $response = $this->orderSpace($space, $this->orderDetails([
            'email' => 'john.bunyan@example.com',
            'payment_token' => $this->paymentGateway->generateToken($this->getCardDetails()),
        ]));

        $order = Order::whereEmail('john.bunyan@example.com')->first();

        $response->assertStatus(201);
        $this->assertFalse(is_null($order));
        $this->assertEquals($order->total, $this->paymentGateway->total());
    }
}
