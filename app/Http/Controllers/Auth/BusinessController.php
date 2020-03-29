<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address as AddressForm;
use App\Http\Requests\BusinessInformation as BusinessInformationForm;

class BusinessController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BusinessInformation  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateInformation(BusinessInformationForm $request, User $user)
    {
        return $this->update($request, $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \pp\Http\Requests\Address  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(AddressForm $request, User $user)
    {
        return $this->update($request, $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function update($request, $user)
    {
        $user->business()->update($request->validated());

        return $this->success(url()->previous());
    }
}
