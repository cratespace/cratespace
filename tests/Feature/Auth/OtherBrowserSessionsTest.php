<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OtherBrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_other_browser_session_data()
    {
        config()->set('session.driver', 'database');

        $user = create(User::class, ['password' => Hash::make('EldridgeJohnsonMyer')]);

        $this->actingAs($user)->get('/');

        auth()->logout();

        $this->assertCount(1, DB::table('sessions')->get());

        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->delete('/user/other-browser-sessions', ['password' => 'EldridgeJohnsonMyer'])
            ->assertRedirect('/')
            ->assertStatus(303);

        $this->assertCount(0, DB::table('sessions')->get());
    }
}
