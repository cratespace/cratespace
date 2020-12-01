<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Tests\Unit\Models\Fixtures\Mock;
use Illuminate\Support\Facades\Route;

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

        $this->assertEquals(config('app.url') . '/mocks/1', $mockModel->path);
    }
}
