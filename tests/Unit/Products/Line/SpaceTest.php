<?php

namespace Tests\Unit\Products\Line;

use Tests\TestCase;
use App\Products\Line\Space;
use App\Models\Space as SpaceModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The instance of the SpaceProduct.
     *
     * @var \App\Products\Line\Space
     */
    protected $space;

    protected function setUp(): void
    {
        parent::setUp();

        $this->space = Space::find(create(SpaceModel::class)->id);
    }

    public function testHasUniqueCode()
    {
        $this->assertNotNull($this->space->getCode());
        $this->assertIsString($this->space->getCode());
    }
}
