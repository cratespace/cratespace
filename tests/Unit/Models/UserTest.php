<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
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
}
