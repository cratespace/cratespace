<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\Space;
use App\Auth\Actions\DeleteUser;
use Illuminate\Support\Facades\DB;

class DeleteUserActionTest extends TestCase
{
    /** @test */
    public function it_can_delete_users_complete_details_from_the_system()
    {
        $space = create(Space::class);
        $user = $space->user;

        $this->assertSame(1, DB::table('spaces')->count());
        $this->assertSame(1, DB::table('users')->count());

        $deletor = new DeleteUser();
        $deletor->delete($user);
        auth()->logout();

        $this->assertSame(0, DB::table('spaces')->count());
        $this->assertSame(0, DB::table('users')->count());
    }
}
