<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\Contracts\Postable;

class AuthenticationTest extends TestCase implements Postable
{
    public function testLoginViewResponseIsReturned()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUserCanAuthenticate()
    {
        create(User::class, $this->validParameters());

        $response = $this->post('/login', $this->validParameters());

        $response->assertRedirect('/home');
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
            'email' => 'james.silverman@monster.com',
            'password' => 'cthuluEmployee',
        ], $overrides);
    }
}
