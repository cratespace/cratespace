<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User as UserForm;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $page = 'account')
    {
        $this->authorize('manage', $user);

        return view('auth.profiles.settings.edit-' . $page, compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, User $user)
    {
        $user->update($request->validated());

        return $this->success(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('manage', $user);

        foreach ($user->spaces as $space) {
            $space->delete();
        }

        $user->business->delete();

        $user->delete();

        auth()->logout();

        return $this->success(
            route('listings'),
            'deleted',
            'We are sorry to see you go.'
        );
    }
}
