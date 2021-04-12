<?php

namespace Tests\Unit\Products;

use stdClass;
use Mockery as m;
use Tests\TestCase;
use App\Models\Product;
use App\Products\Manifest;
use Tests\Fixtures\MockProduct;
use App\Exceptions\InvalidProductException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManifestTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstantiation()
    {
        $manifest = new Manifest(m::mock(Product::class));

        $this->assertInstanceOf(Manifest::class, $manifest);
        $this->assertInstanceOf(Product::class, $manifest->storage());
    }

    public function testStoreProduct()
    {
        $product = new MockProduct('test_product', ['amount' => 1000]);
        $manifest = new Manifest(new Product());

        $manifest->store($product);

        $this->assertDatabaseHas('products', ['code' => $product->code()]);
    }

    public function testThrowsExceptionForInvalidProductClass()
    {
        $product = new stdClass();
        $manifest = new Manifest(new Product());
        $name = get_class($product);

        $this->expectException(InvalidProductException::class);
        $this->expectExceptionMessage("Product [{$name}] is not a valid product");

        $manifest->store($product);
    }

    public function testMatchProduct()
    {
        $product = new MockProduct('test_product');
        $store = Product::create([
            'code' => $product->code(),
            'productable_id' => $product->name(),
            'productable_type' => get_class($product),
        ]);
        $manifest = new Manifest($store);

        $this->assertInstanceOf(MockProduct::class, $manifest->match($product->code()));
    }
}
