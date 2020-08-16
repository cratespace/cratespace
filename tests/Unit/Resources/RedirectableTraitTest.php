<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Tests\Unit\Resources\fixtures\Mock;

class RedirectableTraitTest extends TestCase
{
    /** @test */
    public function it_can_get_relevant_uri_information_of_the_specific_resource()
    {
        $mockModel = new Mock();
        $mockModel->id = 1;

        Route::name('mocks.show')
            ->get('/mocks/{mock}', function () {
                return 'mocked';
            });

        $this->assertEquals('http://localhost/mocks/1', $mockModel->path);
    }
}
