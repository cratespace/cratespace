<?php

namespace Tests\Unit\Purchases;

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
}
