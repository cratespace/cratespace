<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class ManageSpacesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->markTestSkipped();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
