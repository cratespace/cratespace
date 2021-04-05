<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Order;
use App\Services\Stripe\Customer;
use Illuminate\Support\Facades\Event;
use App\Actions\Product\CreateNewOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\PaymentTokens\GeneratePaymentToken;

class CreateNewOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrder()
    {
        Event::fake();

        $product = new MockProduct(1);

        $creator = $this->app->make(CreateNewOrder::class);

        $order = $creator->create($product, array_merge($details = [
            'name' => 'James Silverman',
            'email' => 'j.silvermo@monster.com',
            'phone' => '0712345678',
            'payment_method' => 'pm_card_visa',
            'payment_token' => $token = $this->app->make(GeneratePaymentToken::class)->generate($product),
        ], ['customer' => Customer::create($details)->id]));

        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseMissing('payment_tokens', ['token' => $token]);
    }
}
