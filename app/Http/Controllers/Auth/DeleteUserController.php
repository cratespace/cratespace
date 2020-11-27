<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Actions\DeletesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;

class DeleteUserController extends Controller
{
    /**
     * Delete the current user.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Contracts\Auth\StatefulGuard $auth
     * @param \App\Models\User                         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, StatefulGuard $auth, User $user)
    {
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['password' => [__('This password does not match our records.')]])->errorBag('deleteUser');
        }

        app(DeletesUsers::class)->delete($request->user()->fresh());

        $auth->logout();

        if ($request->wantsJson()) {
            return response('', 204);
        }

        return redirect('/')->with('status', 'user-account-deleted');
    }
}
