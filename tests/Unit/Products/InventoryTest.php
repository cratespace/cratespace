<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Products\Inventory;
use Illuminate\Support\Str;
use Tests\Fixtures\ProductStub;
use App\Exceptions\ProductNotFoundException;

class InventoryTest extends TestCase
{
    public function testStoreProduct()
    {
        $product = new ProductStub('Test Product', 1500);
        $inventory = new Inventory($this->app);

        $inventory->store($product);

        $this->assertTrue($inventory->has($product));
    }

    public function testGetProduct()
    {
        $product = new ProductStub('Test Product', 1500);
        $inventory = new Inventory($this->app);

        $inventory->store($product);

        $this->assertSame($product, $inventory->get($product->getCode()));
    }

    public function testThrowExceptionIfProductNotFoundProduct()
    {
        $this->expectException(ProductNotFoundException::class);

        $inventory = new Inventory($this->app);

        $inventory->get(Str::random(40));
    }
}
