<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\DeleteUserJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_their_account()
    {
        Queue::fake();

        $user = create(User::class, ['password' => 'crazyDruid']);

        $response = $this->actingAs($user)->delete('/user', [
            'password' => 'crazyDruid',
        ]);

        $response->assertStatus(302)->assertRedirect('/');
    }

    /** @test */
    public function an_authenticated_user_can_delete_their_account_through_json()
    {
        Queue::fake();

        $user = create(User::class, ['password' => 'crazyDruid']);

        $response = $this->actingAs($user)->deleteJson('/user', [
            'password' => 'crazyDruid',
        ]);

        $response->assertStatus(204);
    }

    /** @test */
    public function user_account_delete_request_is_pushed_to_queue()
    {
        Queue::fake();

        $user = create(User::class, ['password' => 'crazyDruid']);

        Queue::assertNothingPushed();

        $response = $this->actingAs($user)->deleteJson('/user', [
            'password' => 'crazyDruid',
        ]);

        Queue::assertPushed(DeleteUserJob::class);

        $response->assertStatus(204);
    }
}
