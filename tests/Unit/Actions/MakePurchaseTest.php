<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Order;
use App\Services\Stripe\Customer;
use Illuminate\Support\Facades\Event;
use App\Contracts\Actions\MakesPurchases;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakePurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function testPurchaseTest()
    {
        Event::fake();

        $product = new MockProduct(1);

        $purchaser = $this->app->make(MakesPurchases::class);
        $order = $purchaser->purchase($product, array_merge($details = [
            'name' => 'James Silverman',
            'email' => 'j.silvermo@monster.com',
            'phone' => '0712345678',
            'payment_method' => 'pm_card_visa',
        ], ['customer' => Customer::create($details)->id]));

        $this->assertInstanceOf(Order::class, $order);
    }
}
