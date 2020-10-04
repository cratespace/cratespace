<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Models\Account;
use App\Mail\OrderPlacedMail;
use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class PlaceOrderTest extends TestCase
{
    /**
     * Instance of fake payment gateway.
     *
     * @var \App\Billing\PaymentGateways\StripePaymentGateway
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

    /** @test */
    public function relevant_business_credits_is_updated_on_successful_charge()
    {
        $user = $this->signIn();

        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);
        $order = $this->createNewOrder($space);

        $this->paymentGateway->charge($order, $this->paymentGateway->generateToken($this->getCardDetails()));

        $businessCredit = Account::where('user_id', $order->user_id)->first()->credit;
        $this->assertEquals($businessCredit, $order->subtotal);
    }

    /** @test */
    public function customer_is_redirected_to_order_status_page_on_succesful_order_placement()
    {
        $user = $this->signIn();

        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);

        $response = $this->post("/spaces/{$space->code}/orders", $this->orderDetails($this->getCardDetails()));

        $order = Order::where('space_id', $space->id)->first();

        $response->assertstatus(302)->assertRedirect("/orders/{$order->confirmation_number}");

        $this->get("/orders/{$order->confirmation_number}")
            ->assertSee($order->confirmation_number)
            ->assertSee($order->present()->total)
            ->assertSee($order->present()->price)
            ->assertSee($order->present()->tax)
            ->assertSee($order->email)
            ->assertSee($order->name)
            ->assertSee($order->phone)
            ->assertSee($order->business)
            ->assertSee($space->code);
    }

    /** @test */
    public function an_event_is_fired_once_order_has_been_placed()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);

        Event::fake([
            OrderPlacedEvent::class,
        ]);

        $response = $this->postJson("/spaces/{$space->code}/orders", $this->orderDetails($this->getCardDetails()));

        $order = Order::where('space_id', $space->id)->first();

        Event::assertDispatched(function (OrderPlacedEvent $event) use ($order, $space) {
            return $event->order->id === $order->id && $event->order->space->is($space);
        });
    }

    /** @test */
    public function an_email_is_sent_to_the_customer_once_order_has_been_placed()
    {
        $user = $this->signIn();
        $space = create(Space::class, [
            'user_id' => $user->id,
            'price' => 3250,
            'tax' => 162.5,
        ]);
        $this->calculateCharges($space);

        Mail::fake();

        Mail::assertNothingSent();

        $response = $this->postJson("/spaces/{$space->code}/orders", $this->orderDetails($this->getCardDetails()));

        $order = Order::where('space_id', $space->id)->first();

        Mail::assertQueued(OrderPlacedMail::class, function ($mail) use ($order) {
            return $mail->hasTo($order->email) && $mail->order->id === $order->id;
        });
    }

    /** @test */
    public function full_name_is_required()
    {
        $space = create(Space::class);

        $response = $this->from("/spaces/{$space->code}/checkout")
            ->post("/spaces/{$space->code}/orders", $this->orderDetails([
                'name' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/checkout")
            ->assertSessionHasErrors('name');

        $this->assertEquals(0, Order::count());
    }

    /** @test */
    public function email_address_is_required()
    {
        $space = create(Space::class);

        $response = $this->from("/spaces/{$space->code}/checkout")
            ->post("/spaces/{$space->code}/orders", $this->orderDetails([
                'email' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/checkout")
            ->assertSessionHasErrors('email');

        $this->assertEquals(0, Order::count());
    }

    /** @test */
    public function a_phone_number_is_required()
    {
        $space = create(Space::class);

        $response = $this->from("/spaces/{$space->code}/checkout")
            ->post("/spaces/{$space->code}/orders", $this->orderDetails([
                'phone' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/checkout")
            ->assertSessionHasErrors('phone');

        $this->assertEquals(0, Order::count());
    }

    /** @test */
    public function business_name_is_optional()
    {
        $this->withoutExceptionHandling();

        $space = create(Space::class, ['user_id' => $this->signIn()]);
        $this->calculateCharges($space);

        $response = $this->from("/spaces/{$space->code}/checkout")
            ->post("/spaces/{$space->code}/orders", $this->orderDetails([
                'business' => '',
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => date('Y') + 1,
                'cvc' => '123',
            ]));

        tap(Order::first(), function ($order) use ($response) {
            $response->assertRedirect("/orders/{$order->confirmation_number}");

            $this->assertNull($order->business);
        });
    }
}
