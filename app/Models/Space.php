<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use Laravel\Scout\Searchable;
use App\Models\Traits\Fillable;
use App\Models\Traits\HasStatus;
use App\Models\Traits\Filterable;
use App\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Model;
use Facades\App\Http\Services\Ip\Location;

class Space extends Model
{
    use Fillable;
    use Filterable;
    use Searchable;
    use Presentable;
    use HasUid;
    use HasStatus;

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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray();
    }

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
    public function path()
    {
        return "/spaces/{$this->uid}";
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

    /**
     * Get the order details of the space.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
