<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Account;

class AccountTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = $this->signIn();

        $this->assertInstanceOf(Account::class, $user->account);
    }

    /** @test */
    public function it_has_a_default_credit_balance_of_0()
    {
        $user = $this->signIn();

        $this->assertEquals(0, $user->account->credit);
    }
}
