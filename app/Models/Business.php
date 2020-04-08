<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\Fillable;
use App\Models\Traits\HasPhoto;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use Fillable, HasPhoto;

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
     * Get the user associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
