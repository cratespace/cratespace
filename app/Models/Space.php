<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use Filterable;

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
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
        return numfmt_format_currency(
            app()->make('currency-formatter'),
            $value / 100,
            config('cashier.currency')
        );
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
        return $query->addSelect([
            'business' => Business::select('name')
                ->whereColumn('user_id', 'user_id')
                ->take(1),
            ])
            ->whereStatus('Available')
            ->latest();
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