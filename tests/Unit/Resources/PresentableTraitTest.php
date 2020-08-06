<?php

namespace Tests\Unit\Resources;

use Error;
use Tests\TestCase;
use Tests\Unit\Resources\fixtures\Mock;

class PresentableTraitTest extends TestCase
{
    /** @test */
    public function it_can_constract_a_presenter_for_the_given_model()
    {
        $model = new Mock();

        try {
            $model->present();
        } catch (Error $e) {
            $this->assertEquals("Class 'App\Presenters\MockPresenter' not found", $e->getMessage());

            return;
        }

        $this->fail();
    }
}
