<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Auth\DeleteUser;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('manage', $user = user());

        return view('auth.users.edit', [
            'user' => $user->load('business'),
            'sessions' => $this->sessions($request),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->success(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, StatefulGuard $auth)
    {
        app(DeleteUser::class)->delete($user->fresh());

        $auth->logout();

        return redirect('/', 409);
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     *
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session): Agent
    {
        return tap(new Agent(), function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
