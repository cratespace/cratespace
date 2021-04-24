<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Auth\UpdateUserAddress;
use App\Http\Requests\Auth\AddressInformationRequest;
use App\Http\Responses\Auth\AddressInformationResponse;

class UpdateUserAddressInformationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AddressInformationRequest $request
     * @param \App\Actions\Auth\UpdateUserAddress          $updater
     *
     * @return \App\Http\Responses\AddressInformationResponse
     */
    public function __invoke(AddressInformationRequest $request, UpdateUserAddress $updater)
    {
        $updater->update($request->user(), $request->validated());

        return AddressInformationResponse::dispatch();
    }
}
