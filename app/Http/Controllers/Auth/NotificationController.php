<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'settings' => [
                'notifications_email' => $request['notifications_email'],
                'notifications_mobile' => $request['notifications_mobile']
            ]
        ]);

        return success(route('users.edit', ['user' => $user, 'page' => 'account']));
    }
}
