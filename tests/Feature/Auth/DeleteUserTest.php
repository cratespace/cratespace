<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_his_account()
    {
        Queue::fake();

        $user = create(User::class, ['password' => Hash::make('lordFatHead')]);

        $this->delete('/user/' . $user->username)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($user)
            ->delete('/user/' . $user->username, ['password' => 'lordFatHead'])
            ->assertStatus(302)
            ->assertRedirect('/');

        $user = create(User::class, ['password' => Hash::make('lordButtHead')]);

        $this->actingAs($user)->deleteJson('/user/' . $user->username, [
            'password' => 'lordButtHead',
        ])->assertStatus(204);
    }
}
