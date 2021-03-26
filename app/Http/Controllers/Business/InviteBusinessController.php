<?php

namespace App\Http\Controllers\Business;

use App\Models\User;
use App\Jobs\InviteBusiness;
use App\Http\Controllers\Controller;
use App\Http\Responses\BusinessResponse;
use App\Http\Requests\InviteBusinessRequest;

class InviteBusinessController extends Controller
{
    /**
     * Invite a business in to Cratespace.
     *
     * @param \App\Http\Requests\InviteBusinessRequest $request
     * @param \App\Models\User                         $user
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(InviteBusinessRequest $request, User $user)
    {
        InviteBusiness::dispatch($user);

        return BusinessResponse::dispatch($request);
    }
}
