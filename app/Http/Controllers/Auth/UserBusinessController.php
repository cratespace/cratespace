<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRequest;
use App\Http\Responses\BusinessResponse;
use App\Actions\Auth\UpdateBusinessInformation;

class UserBusinessController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\BusinessRequest          $request
     * @param \App\Actions\Auth\UpdateBusinessInformation $updater
     *
     * @return mixed
     */
    public function __invoke(BusinessRequest $request, UpdateBusinessInformation $updater)
    {
        $updater->update($request->user(), $request->validated());

        return BusinessResponse::dispatch();
    }
}
