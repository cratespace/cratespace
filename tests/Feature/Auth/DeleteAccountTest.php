<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testUserAccountsCanBeDeleted()
    {
        $this->signIn($user = create(User::class));

        $response = $this->delete('/user/profile', [
            'password' => 'password',
        ]);

        $this->assertNull($user->fresh());
    }

    public function testCorrectPasswordMustBeProvidedBeforeAccountCanBeDeleted()
    {
        $this->signIn($user = create(User::class));

        $response = $this->delete('/user/profile', [
            'password' => 'wrong-password',
        ]);

        $this->assertNotNull($user->fresh());
    }

    public function testDeletingUserAccountWillDeleteBusinessProfileAlso()
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        $this->assertIsString($business = $user->business->name);

        $response = $this->delete('/user/profile', [
            'password' => 'password',
        ]);

        $this->assertNull($user->fresh());
        $this->assertNull(Business::whereName($business)->first());
    }
}
