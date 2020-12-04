<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_generate_api_tokens()
    {
        $user = create(User::class);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/api-tokens', [
                'name' => 'token-name',
                'permissions' => ['read'],
            ]);

        $response->assertStatus(200);
        $this->assertIsString($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'token-name']);
    }

    /** @test */
    public function an_authenticated_user_can_update_api_token_permissions()
    {
        $user = create(User::class);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/api-tokens', [
                'name' => 'token-name-updated',
                'permissions' => ['read'],
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'token-name-updated']);

        $token = DB::table('personal_access_tokens')->first();
        $this->assertContains('read', json_decode($token->abilities, true));

        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->putJson('/user/api-tokens/' . $token->id, [
                'permissions' => ['read', 'update'],
            ]);

        $token = DB::table('personal_access_tokens')->first();
        $this->assertContains('update', json_decode($token->abilities, true));
    }

    /** @test */
    public function an_authenticated_user_can_delete_api_tokens()
    {
        $user = create(User::class);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/api-tokens', [
                'name' => 'token-name-updated',
                'permissions' => ['read'],
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'token-name-updated']);

        $token = DB::table('personal_access_tokens')->first();
        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->deleteJson('/user/api-tokens/' . $token->id);

        $this->assertCount(0, DB::table('personal_access_tokens')->get());
    }

    /** @test */
    public function sanctum_protected_route_can_be_accessed()
    {
        $user = create(User::class);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/api-tokens', [
                'name' => 'token-name-updated',
                'permissions' => ['read'],
            ]);

        $token = $response->getContent();

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $this->assertEquals($user, $response->getContent());
    }
}
