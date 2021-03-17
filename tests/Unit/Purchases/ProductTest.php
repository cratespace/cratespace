<?php

namespace Tests\Unit\Purchases;

use Mockery as m;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Fixtures\MockProductModel;

class ProductTest extends TestCase
{
    public function testFullPrice()
    {
        $model = new MockProductModel();
        $model->price = '1000';
        $model->tax = '100';

        $this->assertEquals(1100, $model->fullPrice());
    }

    public function testProductId()
    {
        $model = new MockProductModel();
        $model->code = $code = Str::random(40);

        $this->assertEquals($code, $model->id());
    }

    public function testProductBelongsToBusiness()
    {
        $business = m::mock(Business::class);
        $business->name = 'Gregs';
        $model = m::mock(MockProductModel::class);
        $model->shouldReceive('business')
            ->andReturn($business);

        $this->assertInstanceOf(Business::class, $model->business());
    }
}
