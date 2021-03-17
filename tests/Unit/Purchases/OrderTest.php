<?php

namespace Tests\Unit\Purchases;

use PHPUnit\Framework\TestCase;
use App\Contracts\Purchases\Order;
use Tests\Unit\Fixtures\MockOrderModel;

class OrderTest extends TestCase
{
    public function testInstantiation()
    {
        $order = new MockOrderModel();

        $this->assertInstanceOf(Order::class, $order);
    }
}
