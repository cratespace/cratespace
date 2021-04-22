<?php

namespace Tests\Unit\Values;

use Throwable;
use Illuminate\Support\Str;
use App\Models\Values\Value;
use InvalidArgumentException;
use Tests\Fixtures\ValueStub;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ValueConstraintsStub;

class ValueTest extends TestCase
{
    public function testInstantiation()
    {
        $value = new ValueStub();

        $this->assertInstanceOf(Value::class, $value);
    }

    public function testValuesSetAsArrays()
    {
        $value = new ValueStub([
            'name' => 'mock_value',
            'uid' => $uid = Str::random(40),
        ]);

        $this->assertEquals('mock_value', $value->name);
        $this->assertEquals($uid, $value->uid);
    }

    public function testValueThrowsExceptionIfNonExistant()
    {
        $value = new ValueStub();

        try {
            $value->name;
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertEquals('Property [name] does not exist', $e->getMessage());
        }
    }

    public function testSetValueConstraints()
    {
        $value = new ValueConstraintsStub([
            'uid' => Str::random(40),
        ]);

        try {
            $value->uid;
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertEquals('Property [uid] does not exist', $e->getMessage());
        }
    }
}
