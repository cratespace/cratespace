<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Support\Money;

class MoneyTest extends TestCase
{
    public function testFormatMoneyValue()
    {
        $this->assertEquals('$8.00', Money::format(800));
    }
}
