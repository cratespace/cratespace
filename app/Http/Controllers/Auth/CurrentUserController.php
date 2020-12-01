<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\DeleteUserJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Response;

class CurrentUserController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DeleteUserRequest     $request
     * @param \App\Auth\Contracts\DeletesUsers         $deletor
     * @param \Illuminate\Contracts\Auth\StatefulGuard $auth
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(DeleteUserRequest $request, StatefulGuard $auth): Response
    {
        $this->authorize('delete', $request->user());

        DeleteUserJob::dispatch($request->user());

        $auth->logout();

        return $request->wantsJson()
            ? response()->json('', 204)
            : redirect('/');
    }
}
