<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\Auth\LogoutOtherBrowserSessionsRequest;
use App\Http\Responses\Auth\LogoutOtherBrowserSessionsResponse;

class OtherBrowserSessionsController extends Controller
{
    /**
     * Logout from other browser sessions.
     *
     * @param \App\Http\Requests\Auth\LogoutOtherBrowserSessionsRequest $request
     * @param \Illuminate\Contracts\Auth\StatefulGuard                  $guard
     *
     * @return mixed
     */
    public function __invoke(LogoutOtherBrowserSessionsRequest $request, StatefulGuard $guard)
    {
        $guard->logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return LogoutOtherBrowserSessionsResponse::dispatch();
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
