<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Tests\TestCase;
use App\Products\Manifest;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Product;
use App\Actions\Product\CreateNewProduct;
use App\Contracts\Actions\CreatesNewResources;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewProductTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstancetiation()
    {
        $creator = new CreateNewProduct(m::mock(Manifest::class));

        $this->assertInstanceOf(CreatesNewResources::class, $creator);
    }

    public function testCreateNewProduct()
    {
        $manifest = $this->app->make(Manifest::class);
        $creator = new CreateNewProduct($manifest);

        $product = $creator->create(MockProduct::class, [
            'name' => 'test_product',
            'amount' => 1000,
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertTrue($manifest->has($product->code()));
    }
}
