<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Facades\Queue;
use Cratespace\Sentinel\Jobs\DeleteUserJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteUserJobIsQueued()
    {
        Queue::fake();

        $this->signIn(create(User::class));

        $this->delete('/user/profile', ['password' => 'password']);

        Queue::assertPushed(DeleteUserJob::class);
    }

    public function testUserAccountsCanBeDeleted()
    {
        $this->signIn($user = create(User::class));

        $this->delete('/user/profile', ['password' => 'password']);

        $this->assertNull($user->fresh());
    }

    public function testUserAccountsCanBeDeletedThroughJson()
    {
        $this->signIn($user = create(User::class));

        $response = $this->deleteJson('/user/profile', ['password' => 'password']);

        $response->assertStatus(204);
        $this->assertNull($user->fresh());
    }

    public function testBusinessOrdersAndSpacesAreDeleted()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());

        create(Space::class, ['user_id' => $user->id], 20);
        create(Order::class, ['user_id' => $user->id], 20);

        $this->assertCount(20, $user->spaces);
        $this->assertCount(20, $user->orders);

        $this->delete('/user/profile', ['password' => 'password']);

        $this->assertCount(0, $user->spaces->fresh());
        $this->assertCount(0, $user->orders->fresh());
        $this->assertNull($user->fresh());
    }

    public function testCustomerOrdersAreDeleted()
    {
        $this->signIn($user = User::factory()->asCustomer()->create());

        create(Order::class, ['customer_id' => $user->id], 20);

        $this->assertCount(20, $user->orders);

        $this->delete('/user/profile', ['password' => 'password']);

        $this->assertCount(0, $user->orders->fresh());
        $this->assertNull($user->fresh());
    }

    public function testCorrectPasswordMustBeProvidedBeforeAccountCanBeDeleted()
    {
        $this->signIn($user = create(User::class));

        $this->delete('/user/profile', ['password' => 'wrong-password']);

        $this->assertNotNull($user->fresh());
    }
}
