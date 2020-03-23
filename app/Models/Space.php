<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use App\Models\Traits\Fillable;
use App\Models\Traits\Filterable;
use App\Models\Traits\Recordable;
use App\Models\Traits\Searchable;
use App\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use Fillable,
        Recordable,
        Filterable,
        Searchable,
        HasUid,
        Presentable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'departs_at', 'arrives_at', 'height',
        'width', 'length', 'weight', 'note', 'price',
        'user_id', 'origin', 'destination', 'status',
        'type', 'base'
    ];

    /**
     * Model attributes to search from.
     *
     * @var array
     */
    protected static $searchableColumns = ['uid', 'origin', 'destination'];

    /**
     * Set the books's price in cents.
     *
     * @param string $value
     * @return string
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Get the books's price.
     *
     * @param  string  $value
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
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if the shipment is due and has left.
     *
     * @return bool
     */
    public function departed()
    {
        return $this->departs_at <= now() ||
            $this->status === 'Expired';
    }

    /**
     * Mark the space as expired.
     */
    public function markAs($status)
    {
        $this->update(['status' => $status]);
    }

    /**
     * Mark space as ordered.
     */
    public function order()
    {
        $this->markAs('Ordered');
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
}
