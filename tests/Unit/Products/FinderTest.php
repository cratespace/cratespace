<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Products\Finder;
use App\Products\Inventory;
use Illuminate\Support\Str;
use App\Products\Line\Space;
use Tests\Fixtures\ProductStub;
use App\Models\Space as ModelsSpace;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinderTest extends TestCase
{
    use RefreshDatabase;

    public function testFindProductFromInventory()
    {
        $product = new ProductStub('Test Product', 1500);
        $inventory = new Inventory($this->app);
        $finder = new Finder($inventory);

        $inventory->store($product);

        $this->assertSame($product, $finder->find($product->getCode()));
    }

    public function testFindProductFromDatabase()
    {
        $product = Space::find(create(ModelsSpace::class)->id);
        $inventory = new Inventory($this->app);
        $finder = new Finder($inventory);

        $this->assertTrue($product->is($finder->find($product->getCode())));
    }

    public function testThrowsExceptionIfProductNotFound()
    {
        $this->expectException(ProductNotFoundException::class);

        $inventory = new Inventory($this->app);
        $finder = new Finder($inventory);

        $finder->find(Str::random(24));
    }
}
