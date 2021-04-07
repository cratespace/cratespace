<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Products\Manifest;
use Tests\Fixtures\MockProduct;
use App\Actions\Product\FindProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindProductTest extends TestCase
{
    use RefreshDatabase;

    public function testFindProduct()
    {
        $product = new MockProduct('test_product');
        $manifest = $this->app->make(Manifest::class);
        $manifest->store($product);

        $found = $this->app->make(FindProduct::class)->find($product->code());

        $this->assertInstanceOf(MockProduct::class, $found);
    }
}
