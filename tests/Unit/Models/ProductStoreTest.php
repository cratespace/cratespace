<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use Tests\Fixtures\MockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifyExistingProductCode()
    {
        $product1 = new MockProduct('test_product_1');
        $product2 = new MockProduct('test_product_2');

        Product::create([
            'code' => $product1->code(),
            'productable_id' => $product1->name(),
            'productable_type' => get_class($product1),
        ]);

        $this->assertTrue((new Product())->has($product1));
        $this->assertFalse((new Product())->has($product2));
    }

    public function testFindUsingProductCode()
    {
        $product1 = new MockProduct('test_product_1');
        $product2 = new MockProduct('test_product_2');

        Product::create([
            'code' => $product1->code(),
            'productable_id' => $product1->name(),
            'productable_type' => get_class($product1),
        ]);

        $store = new Product();

        $this->assertNotNull($store->findUsingCode($product1->code()));
        $this->assertNull($store->findUsingCode($product2->code()));
    }
}
