<?php

namespace Tests\Unit\Products;

use Mockery as m;
use Tests\TestCase;
use App\Support\Money;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Order;
use App\Contracts\Billing\Payment;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Crypt;

class ProductTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstantiation()
    {
        $product = new MockProduct('test_product');

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testHasName()
    {
        $product = new MockProduct('test_product');

        $this->assertEquals('test_product', $product->name());
    }

    public function testGeneratesCode()
    {
        $product = new MockProduct('test_product');

        [$class, $name] = explode('-', Crypt::decryptString($product->code()));

        $this->assertEquals($product->name(), $name);
    }

    public function testGetMerchantDetails()
    {
        $product = new MockProduct('test_product');

        $this->assertEquals('Father Jack Hackett', $product->merchant()->name);
    }

    public function testFormatPrice()
    {
        $product = new MockProduct('test_product');

        $this->assertEquals(Money::format($product->fullAmount()), $product->amount());
    }

    public function testPrice()
    {
        $product = new MockProduct('test_product');

        $this->assertEquals($product->fullAmount(), $product->rawAmount());
    }

    public function testGetOrderDetails()
    {
        $product = new MockProduct('test_product');

        $product->placeOrder(m::mock(Payment::class));

        $this->assertInstanceOf(Order::class, $product->getOrderDetails());
    }
}
