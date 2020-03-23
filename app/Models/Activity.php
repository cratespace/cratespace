<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Fetch the associated subject for the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Fetch user related to activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Fetch an activity feed for the given user.
     *
     * @param \App\Models\User $user
     * @param int  $take
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function feed($user, $take = 50)
    {
        return static::where('user_id', $user->id)
                     ->latest()->with('subject')
                     ->take($take)->get()
                     ->groupBy(function ($activity) {
                         return $activity->created_at->format('F j, Y');
                     });
    }

    /**
     * Get specific user associated with the activity.
     *
     * @return strig
     */
    public function getUsernameAttribute()
    {
        return $this->user->is(auth()->user()) ? 'You' : $this->user->username;
    }
}
