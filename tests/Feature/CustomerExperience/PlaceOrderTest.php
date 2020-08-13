<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Models\Account;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Contracts\Billing\PaymentGateway;
use App\Mail\OrderPlaced as OrderPlacedMail;
use App\Events\OrderPlaced as OrderPlacedEvent;
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
        $order = $space->placeOrder($this->orderDetails());

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
            ->assertSee($space->present()->price)
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
            return $mail->hasTo($order->email) &&
            $mail->order->id === $order->id;
        });
    }
}
