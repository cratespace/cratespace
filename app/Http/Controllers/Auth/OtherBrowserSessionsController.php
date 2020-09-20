<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\OtherBrowserSessionsRequest;

class OtherBrowserSessionsController extends Controller
{
    /**
     * Logout from other browser sessions.
     *
     * @param \App\Http\Requests\OtherBrowserSessionsRequest $request
     * @param \Illuminate\Contracts\Auth\StatefulGuard       $guard
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(OtherBrowserSessionsRequest $request, StatefulGuard $guard)
    {
        $guard->logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return back(303);
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getKey())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
