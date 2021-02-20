<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessInformationTest extends TestCase
{
    use RefreshDatabase;

    public function testProfileInformationCanBeUpdated()
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        $response = $this->put('/user/business', [
            'name' => 'Example, Co.',
            'about' => 'Example company profile.',
            'street' => '768 Potal Coast',
            'city' => 'Atlastis',
            'state' => 'Upper Core',
            'country' => 'Saturn',
            'postcode' => '209sda98h3ep',
        ]);

        $response->assertStatus(303);

        $this->assertEquals('Example, Co.', $user->business->name);
        $this->assertEquals('Example company profile.', $user->business->about);
    }
}
