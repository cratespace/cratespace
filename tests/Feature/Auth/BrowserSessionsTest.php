<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function testOtherBrowserSessionsCanBeLoggedOut()
    {
        $this->signIn($user = create(User::class));

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'password',
        ]);

        $this->assertEmpty($user->sessions);
        $response->assertSessionHasNoErrors();
    }

    public function testValidPasswordIsRequired()
    {
        $this->signIn(create(User::class));

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'invalid-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
