<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewListingTest extends TestCase
{
    use RefreshDatabase;

    public function testCustomerCanViewListing()
    {
        $this->withoutExceptionHandling();

        $space = create(Space::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($space->code);
    }
}
