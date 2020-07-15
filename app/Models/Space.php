<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Facades\App\Http\Services\Ip\Location;

class Space extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'departs_at', 'arrives_at', 'height', 'width', 'length',
        'weight', 'note', 'price', 'user_id', 'origin', 'destination',
        'status', 'type', 'base',
    ];

    /**
     * Set the space's price in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Get the books's price.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function path(): string
    {
        return route('spaces.show');
    }

    /**
     * Scope a query to only include spaces based in user's country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList($query)
    {
        return $query->whereBase(Location::getCountry())
            ->whereStatus('Available');
    }

    /**
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
