<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\Sluggable;
use App\Providers\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Sluggable;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'user_id', 'channel_id', 'slug',
        'replies_count', 'visits', 'locked', 'pinned',
    ];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['user', 'channel'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/support/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * Fetch the path to the thread as a property.
     */
    public function getPathAttribute()
    {
        if (!$this->channel) {
            return '';
        }

        return $this->path();
    }

    /**
     * A thread belongs to a creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A thread is assigned a channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class)->withoutGlobalScope('active');
    }

    /**
     * A thread may have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     *
     * @return \App\Models\Reply
     */
    public function addReply(array $data)
    {
        $reply = $this->replies()->create($data);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\ThreadFilters            $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function hasUpdatesFor($user)
    {
        return $this->updated_at > cache(
            $user->visitedThreadCacheKey($this)
        );
    }
}
