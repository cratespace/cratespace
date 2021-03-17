<?php

namespace Tests\Unit\Support;

use App\Support\Attribute;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Fixtures\MockAttribute;

class AttributeTest extends TestCase
{
    public function testInstantiation()
    {
        $attribute = new MockAttribute();

        $this->assertInstanceOf(Attribute::class, $attribute);
    }

    public function testAttributeName()
    {
        $attribute = new MockAttribute();

        $this->assertEquals('mock', $attribute->name());
    }
}
