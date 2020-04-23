<?php

namespace App\Models\Concerns;

use App\Models\ThreadSubscription;

trait HandlesSubscriptions
{
    /**
     * Subscribe a user to the current thread.
     *
     * @param int|null $userId
     *
     * @return $this
     */
    public function subscribe(?int $userId = null)
    {
        $this->subscriptions()->create([
<<<<<<< HEAD
            'user_id' => $userId ?? user('id'),
=======
            'user_id' => $userId ?: user('id'),
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe(?int $userId = null)
    {
        $this->subscriptions()
<<<<<<< HEAD
            ->where('user_id', $userId ?? auth()->id())
=======
            ->where('user_id', $userId ?: auth()->id())
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
            ->delete();
    }

    /**
     * A thread can have many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
