<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testUserAccountsCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn($user = User::factory()->asBusiness()->create());

        $this->delete('/user/profile', ['password' => 'password']);

        $this->assertNull($user->fresh());
    }

    public function testCorrectPasswordMustBeProvidedBeforeAccountCanBeDeleted()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());

        $this->delete('/user/profile', ['password' => 'wrong-password']);

        $this->assertNotNull($user->fresh());
    }
}
