<?php

namespace Tests\Unit\Rules;

use Mockery as m;
use App\Rules\ProductRule;
use PHPUnit\Framework\TestCase;
use App\Contracts\Billing\Product;

class ProductRuleTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testValidateProduct()
    {
        $product = m::mock(Product::class);
        $product->shouldReceive('available')
            ->once()
            ->andReturn(true);
        $rule = new ProductRule();

        $this->assertTrue($rule->passes('product', $product));
    }

    public function testErrorMessage()
    {
        $product = m::mock(Product::class);
        $product->shouldReceive('available')
            ->once()
            ->andReturn(false);
        $rule = new ProductRule();

        $this->assertFalse($rule->passes('product', $product));
        $this->assertEquals('This product is unavailable at the moment.', $rule->message());
    }
}
