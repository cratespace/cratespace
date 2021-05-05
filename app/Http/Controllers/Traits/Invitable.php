<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use App\Jobs\InviteBusiness;
use Illuminate\Http\Request;
use App\Exceptions\InvalidActionException;

trait Invitable
{
    /**
     * Invite given business user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return void
     */
    public function invite(Request $request, User $user): void
    {
        if (! $request->user()->isResponsibleFor($user)) {
            throw new InvalidActionException('An authorized personale is not responsible for this action.');
        }

        InviteBusiness::dispatch($user);
    }
}
