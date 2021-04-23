<?php

namespace Tests\Unit\Presenters;

use InvalidArgumentException;
use Tests\Fixtures\ModelStub;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\MockPresenter;

class PresenterTest extends TestCase
{
    protected $model;
    protected $presenter;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = new ModelStub();
        $this->model->foo = 'bar';
        $this->presenter = new MockPresenter($this->model);
    }

    public function testCanPresentMutatedModelAttribute()
    {
        $this->assertEquals('Bar', $this->presenter->foobar);
    }

    public function testThrowsExceptionIfPresenterMethodUndefined()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tests\Fixtures\MockPresenter does not respond to the property or method "barbaz"');

        $this->presenter->barbaz;
    }
}
