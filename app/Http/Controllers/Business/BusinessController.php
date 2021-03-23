<?php

namespace App\Http\Controllers\Business;

use App\Models\Business;
use App\Jobs\InviteBusiness;
use Illuminate\Http\Request;
use App\Actions\Auth\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRequest;
use App\Http\Responses\BusinessResponse;

class BusinessController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BusinessRequest $request
     * @param \App\Actions\Auth\CreateNewUser    $creator
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessRequest $request, CreateNewUser $creator)
    {
        $user = $creator->create($request->validated());

        if ((bool) $request->invite) {
            InviteBusiness::dispatch($user);
        }

        return BusinessResponse::dispatch($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Business     $business
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
    }
}
