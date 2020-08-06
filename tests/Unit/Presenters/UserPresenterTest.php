<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;

class UserPresenterTest extends TestCase
{
    /** @test */
    public function it_can_display_user_credit_balance_in_money_format()
    {
        $user = create(User::class);
        $userAccount = create(Account::class, [
            'user_id' => $user->id,
            'credit' => 1249,
        ]);

        $this->assertEquals('$12.49', $user->present()->creditBalance);
    }
}
