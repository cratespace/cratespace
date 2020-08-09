<?php

namespace Tests\Feature\CustomerExperience;

use Tests\TestCase;
use App\Models\Space;
use App\Support\Formatter;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class ViewCheckoutPageTest extends TestCase
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

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function a_customer_is_redirected_to_the_checkout_page_when_book_button_is_clicked()
    {
        $space = create(Space::class);

        $this->get("/spaces/{$space->uid}/checkout")->assertStatus(200);
    }

    /** @test */
    public function the_relevant_charges_are_calculated_when_a_space_is_booked()
    {
        $space = create(Space::class);

        $this->get("/spaces/{$space->uid}/checkout")->assertStatus(200);

        $charges = cache()->get('charges');
        $this->assertTrue(cache()->has('charges'));
        $this->assertTrue(is_array($charges));
        $this->assertEquals($space->price, $charges['price']);

        foreach (['price', 'service', 'tax', 'total'] as $value) {
            $this->assertTrue(array_key_exists($value, $charges));
        }
    }

    /** @test */
    public function customers_can_see_the_relavant_sharges_calculated()
    {
        $space = create(Space::class);

        $response = $this->get("/spaces/{$space->uid}/checkout");

        $charges = [];

        foreach (cache()->get('charges') as $name => $amount) {
            $charges[$name] = Formatter::money((int) $amount);
        }

        $response->assertStatus(200)
            ->assertSee($space->uid)
            ->assertSee($space->present()->price)
            ->assertSee($charges['price'])
            ->assertSee($charges['subtotal'])
            ->assertSee($charges['service'])
            ->assertSee($charges['tax'])
            ->assertSee($charges['total']);
    }

    /** @test */
    public function customers_can_see_the_relavant_space_details()
    {
        $space = create(Space::class);

        $response = $this->get("/spaces/{$space->uid}/checkout")
            ->assertStatus(200)
            ->assertSee($space->present()->price)
            ->assertSee($space->uid)
            ->assertSee($space->businessName)
            ->assertSee($space->type)
            ->assertSee($space->origin)
            ->assertSee($space->destination)
            ->assertSee($space->departs_at->format('M j, g:ia'))
            ->assertSee($space->arrives_at->format('M j, g:ia'))
            ->assertSee($space->height)
            ->assertSee($space->length)
            ->assertSee($space->width)
            ->assertSee($space->volume);
    }

    /** @test */
    public function space_details_are_removed_from_cache_if_checkout_process_is_canceled()
    {
        $space = create(Space::class);

        $this->get("/spaces/{$space->uid}/checkout")->assertStatus(200);

        $this->assertTrue(cache()->has('charges'));

        $_SERVER['REMOTE_ADDR'] = '122.255.0.0';

        $this->get('/')->assertStatus(200);

        unset(
            $_SERVER['HTTP_CLIENT_IP'],
            $_SERVER['HTTP_X_FORWARDED_FOR'],
            $_SERVER['REMOTE_ADDR']
        );

        $_SERVER['REMOTE_ADDR'] = null;

        $this->assertTrue(!cache()->has('charges'));
    }
}
