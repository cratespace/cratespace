<?php

namespace Tests\Feature\Customer;

use Throwable;
use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Events\OrderPlaced;
use App\Events\PaymentFailed;
use App\Services\Stripe\Payment;
use App\Events\PaymentSuccessful;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Exceptions\InvalidProductException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;
use Cratespace\Preflight\Testing\Contracts\Postable;
use App\Notifications\NewOrderPlaced as NewOrderPlacedNotification;

/**
 * @group Stripe
 */
class PurchaseTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testPurchaseProduct()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);
        $this->assertFalse($product->available());
    }

    public function testValidNameRequired()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'name' => '',
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertTrue($product->available());
    }

    public function testValidEmailRequired()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'email' => '',
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertTrue($product->available());
    }

    public function testValidPaymentMethodRequired()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_method' => '',
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('payment_method');
        $this->assertTrue($product->available());
    }

    public function testValidPaymentTokenRequired()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('payment_token');
        $this->assertTrue($product->available());
    }

    public function testValidProductDetailsAreRequired()
    {
        $this->withoutExceptionHandling();

        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        try {
            $response = $this->post(
                '/checkout/DFHO8Q73EGWHQW8D',
                $this->validParameters([
                    'payment_token' => $token,
                ])
            );
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidProductException::class, $e);
            $this->assertEquals('Product with code [DFHO8Q73EGWHQW8D] does not exist', $e->getMessage());
            $this->assertTrue($product->available());

            return;
        }

        $this->fail();
    }

    public function testCustomerDetailsAreaAutoInjected()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'customer' => '',
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);
        $this->assertFalse($product->available());
    }

    public function testNewPaymentIsCreated()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);
        $this->assertInstanceOf(Payment::class, $product->order->payment);
        $this->assertEquals('succeeded', $product->order->payment->status);
        $this->assertEquals($customer->customerId(), $product->order->payment->customer);
    }

    public function testPaymentSuccessfulEventIsDispatched()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);

        Event::assertDispatched(function (PaymentSuccessful $event) use ($product) {
            return $event->payment->id === $product->order->payment->id;
        });
    }

    public function testOrderPlacedEventIsDispatched()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
            OrderPlaced::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);

        Event::assertDispatched(function (OrderPlaced $event) use ($product) {
            return $event->order->is($product->order);
        });
    }

    public function testNewOrderPlacedNotificationIsSentToBusiness()
    {
        Mail::fake();
        Notification::fake();
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);

        Notification::assertSentTo(
            [$product->merchant()], NewOrderPlacedNotification::class
        );
    }

    public function testNewOrderPlacedMailIsSentToBusiness()
    {
        Mail::fake();
        Notification::fake();
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);

        Notification::assertSentTo(
            [$product->merchant()],
            NewOrderPlacedNotification::class,
            function ($notification, $channels) use ($product) {
                return $notification->toMail($product->merchant())->hasTo(
                    $product->merchant()->email
                );
            }
        );
    }

    public function testNewOrderPlacedMailIsSentToCustomer()
    {
        Notification::fake();
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
        ]);

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/checkout/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);

        Notification::assertSentTo(
            [$customer],
            NewOrderPlacedNotification::class,
            function ($notification, $channels) use ($customer) {
                return $notification->toMail($customer)->hasTo(
                    $customer->email
                );
            }
        );
    }

    /**
     * Generate a pyament token to proceed with purchase.
     *
     * @param \App\Contracts\Billing\Product $product
     *
     * @return string
     */
    protected function generatePyamentToken(Product $product): string
    {
        return $this->app->make(GeneratePaymentToken::class)->generate($product);
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'James Silverman',
            'email' => 'james.silver@monster.com',
            'phone' => '0723573567',
            'business' => 'Cthulu',
            'payment_method' => 'pm_card_visa',
        ], $overrides);
    }
}
