<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewOrderPlaced;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if (request('status') === 'Unread') {
            $notifications = $user->unreadNotifications()->get();
        } else {
            $notifications = $user->readNotifications()->get();
        }

        return view('businesses.notifications', [
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

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

        return $this->success(route('users.edit', ['user' => $user, 'page' => 'account']));
    }

    /**
     * MArk specified notification as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function markread(Request $request, User $user)
    {
        $user->unreadNotifications
            ->where('id', $request->notification)
            ->markAsRead();

        return back();
    }

    /**
     * MArk specified notification as unread.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function markunread(Request $request, User $user)
    {
        $user->readNotifications
            ->where('id', $request->notification)
            ->markAsUnread();

        return back();
    }
}
