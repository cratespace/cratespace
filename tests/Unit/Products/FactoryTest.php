<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\User;
use App\Contracts\Products\Product;
use Tests\Fixtures\ProductFactoryStub;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeProduct()
    {
        $factory = new ProductFactoryStub();
        $product = $factory->make($attributes = [
            'name' => 'Test Product',
            'price' => 1000,
            'description' => 'Test product',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($attributes, $product->details());
    }

    public function testGetAuthUser()
    {
        $this->signIn($user = create(User::class));

        $factory = new ProductFactoryStub();

        $this->assertSame($user, $factory->user());
    }

    public function testGetProductInstance()
    {
        $factory = new ProductFactoryStub();
        $product = $factory->make($attributes = [
            'name' => 'Test Product',
            'description' => 'Test product',
        ]);

        $this->assertSame($product, $factory->getProductInstance());
    }
}
