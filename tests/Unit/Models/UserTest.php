<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_settings_is_saved_and_retrieved_using_custom_casts()
    {
        $user = create(User::class);

        $this->assertTrue(is_array($user->settings));
    }

    /** @test */
    public function a_user_can_retrieve_their_session_data()
    {
        config()->set('session.driver', 'database');

        $user = create(User::class);

        $this->actingAs($user)->get('/');

        auth()->logout();

        $this->actingAs($user)->get('/');

        $this->assertNotEmpty($user->sessions(request()));
    }
}
