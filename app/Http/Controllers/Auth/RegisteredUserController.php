<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Contracts\Auth\CreatesNewUsers;
use App\Http\Requests\CreateNewUserRequest;
use Illuminate\Contracts\Auth\StatefulGuard;

class RegisteredUserController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected StatefulGuard $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Create a new registered user.
     *
     * @param \Illuminate\Http\Request       $request
     * @param \App\Contracts\CreatesNewUsers $creator
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewUserRequest $request, CreatesNewUsers $creator)
    {
        event(new Registered(
            $user = $creator->create($request->validated())
        ));

        $this->guard->login($user);

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect(config('auth.defaults.home'));
    }
}
