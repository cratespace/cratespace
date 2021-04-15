<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Inertia\Response as InertiaResponse;
use App\Contracts\Actions\CreatesNewUsers;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Responses\Auth\RegisterResponse;

class RegistrationController extends Controller
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
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
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
     * @return \Inertia\Response
     */
    public function create(Request $request): InertiaResponse
    {
        return Inertia::render('Auth/Register', [
            'type' => $request->get('type', 'customer'),
        ]);
    }

    /**
     * Create a new registered user.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     * @param \App\Contracts\Actions\CreatesNewUsers  $creator
     *
     * @return mixed
     */
    public function store(RegisterRequest $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->validated());

        event(new Registered($user));

        $this->guard->login($user);

        return RegisterResponse::dispatch($user);
    }
}
