<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\NewPasswordRequest;
use App\Auth\Actions\CompletePasswordReset;
use App\Contracts\Auth\ResetsUserPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Auth\Traits\HasBroker;

class NewPasswordController extends Controller
{
    use HasBroker;

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
     * Show the new password view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Reset the user's password.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(NewPasswordRequest $request, ResetsUserPasswords $resetor): Response
    {
        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Authenticatable $user) use ($request, $resetor) {
                $resetor->reset($user, $request->all());

                app(CompletePasswordReset::class)($this->guard, $user);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return $request->wantsJson()
                ? response()->json(['message' => trans($status)])
                : redirect()->route('signin')->with('status', trans($status));
        }

        if ($request->wantsJson()) {
            throw ValidationException::withMessages(['email' => [trans($status)]]);
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($status)]);
    }
}
