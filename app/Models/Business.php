<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\Fillable;
use App\Models\Traits\HasPhoto;
use App\Models\Traits\Sluggable;
use App\Models\Traits\Recordable;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use Fillable, Recordable, Sluggable, HasPhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'photo', 'street', 'email',
        'phone', 'city', 'state', 'country', 'postcode', 'user_id',
    ];

    /**
     * Model events that require activity recording.
     *
     * @var array
     */
    protected static $recordableEvents = ['updated'];

    /**
     * Get the user associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
