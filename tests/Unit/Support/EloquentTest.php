<?php

namespace Tests\Unit\Support;

use Tests\Fixtures\ModelStub;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\EloquentStub;
use Tests\Concerns\InteractsWithProtectedQualities;

class EloquentTest extends TestCase
{
    use InteractsWithProtectedQualities;

    public function testHasModelInstance()
    {
        $eloquent = new EloquentStub($model = new ModelStub());

        $this->assertSame($model, $this->accessProperty($eloquent, 'model'));
    }
}
