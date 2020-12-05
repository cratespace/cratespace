<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Contracts\Auth\CreatesNewUsers;
use App\Http\Requests\CreateNewUserRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

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
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Create a new registered user.
     *
     * @param \App\Http\Requests\CreateNewUserRequest $request
     * @param \App\Contracts\CreatesNewUsers          $creator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(CreateNewUserRequest $request, CreatesNewUsers $creator): Response
    {
        event(new Registered($user = $creator->create($request->validated())));

        $this->guard->login($user);

        return $request->wantsJson()
            ? response()->json('', 201)
            : redirect(config('auth.defaults.home'));
    }
}
