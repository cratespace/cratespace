<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowserSessionsTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testOtherBrowserSessionsCanBeLoggedOut()
    {
        $user = create(User::class, [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->signIn($user)
            ->delete('/user/other-browser-sessions', [
                'password' => 'cthuluEmployee',
            ]);

        $response->assertStatus(303);
        $response->assertSessionHasNoErrors();
    }

    public function testOtherBrowserSessionsCanBeLoggedOutThroughJsonRequest()
    {
        $user = create(User::class, [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->signIn($user)
            ->deleteJson('/user/other-browser-sessions', [
                'password' => 'cthuluEmployee',
            ]);

        $response->assertStatus(204);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'password' => 'cthuluEmployee',
        ], $overrides);
    }
}
