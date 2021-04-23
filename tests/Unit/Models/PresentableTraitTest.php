<?php

namespace Tests\Unit\Models;

use Error;
use Tests\Fixtures\ModelStub;
use PHPUnit\Framework\TestCase;

class PresentableTraitTest extends TestCase
{
    public function testModelCanGetMutatedModelAttribute()
    {
        $this->expectException(Error::class);

        $model = new ModelStub();
        $model->foo = 'bar';
        $model->present()->foobar;
    }
}
