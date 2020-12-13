<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Auth\UpdatesUserProfiles;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View|Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        $this->authorize('view', $user = $request->user());

        return $request->wantsJson()
            ? response()->json($user)
            : view('profiles.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserProfileRequest $request
     * @param \App\Contracts\Auth\UpdatesUserProfiles     $updator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(
        UpdateUserProfileRequest $request,
        UpdatesUserProfiles $updator
    ): Response {
        $this->authorize('update', $user = $request->user());

        $updator->update($user, $request->validated());

        return $request->wantsJson()
            ? response()->json('', 200)
            : back()->with('status', 'profile-updated');
    }
}
