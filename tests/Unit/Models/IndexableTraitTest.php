<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Tests\Unit\Models\fixtures\Mock;

class IndexableTraitTest extends TestCase
{
    /** @test */
    public function it_can_get_name_of_the_model_in_lowercase()
    {
        $mockModel = new Mock();

        $this->assertEquals('mock', $mockModel->getResource());
    }
}
