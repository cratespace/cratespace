<?php

namespace Tests\Unit\Products;

use Mockery as m;
use Tests\TestCase;
use App\Products\Finder;
use App\Products\Manifest;
use Illuminate\Support\Str;
use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Product;
use App\Exceptions\InvalidProductException;
use App\Exceptions\ProductNotFoundException;

class FinderTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstantiation()
    {
        $finder = new Finder(m::mock(Manifest::class));

        $this->assertInstanceOf(Finder::class, $finder);
    }

    public function testFindProduct()
    {
        $product = new MockProduct('test_product');
        $manifest = m::mock(Manifest::class);
        $manifest->shouldReceive('match')
            ->once()
            ->with($product->code())
            ->andReturn($product);
        $finder = new Finder($manifest);

        $this->assertEquals($product, $finder->find($product->code()));
    }

    public function testUnregisteredProductThrowsException()
    {
        $this->expectException(InvalidProductException::class);

        $manifest = m::mock(Manifest::class);
        $manifest->shouldReceive('match')
            ->once()
            ->with($code = Str::random(40))
            ->andThrow(ProductNotFoundException::class);
        $finder = new Finder($manifest);

        $finder->find($code);
    }

    public function testFindProductUsingCode()
    {
        $product = new MockProduct('test_product');
        $manifest = m::mock(Manifest::class);
        $manifest->shouldReceive('resolve')
            ->once()
            ->with(get_class($product), $product->name())
            ->andReturn($product);
        $finder = new Finder($manifest);
        $found = $finder->identifyUsingCode($product->code());

        $this->assertInstanceOf(Product::class, $found);
        $this->assertEquals($product->name(), $found->name());
    }
}
