<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use App\Jobs\InviteBusiness;
use App\Http\Requests\Request;
use App\Exceptions\InvalidActionException;

trait Invitable
{
    /**
     * Invite given business user.
     *
     * @param \App\Http\Requests\Request $request
     * @param \App\Models\User           $user
     *
     * @return void
     */
    public function invite(Request $request, User $user): void
    {
        $request->tap(function (User $admin) use ($user): void {
            if (! $admin->isResponsibleFor($user)) {
                throw new InvalidActionException('Only adinistrators can invite a new business');
            }

            InviteBusiness::dispatch($user);
        });
    }
}
