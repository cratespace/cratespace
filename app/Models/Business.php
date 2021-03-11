<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\InteractsWithCredit;
use Cratespace\Preflight\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cratespace\Sentinel\Models\Traits\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;
    use HasProfilePhoto;
    use Sluggable;
    use InteractsWithCredit;
    use Presentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'credit',
        'description',
        'street',
        'city',
        'state',
        'country',
        'postcode',
        'user_id',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'credit',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user the business belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
