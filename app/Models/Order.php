<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use Laravel\Scout\Searchable;
use App\Models\Traits\Fillable;
use App\Models\Traits\Graphable;
use App\Models\Traits\Filterable;
use App\Models\Concerns\GeneratesUid;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Fillable,
        Filterable,
        HasUid,
        GeneratesUid,
        Graphable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'business', 'status',
        'total', 'tax', 'service', 'user_id', 'space_id',
        'uid',
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
    protected $with = ['space'];

    /**
     * Get the space associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    /**
     * Get the space associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Mark the space as expired.
     */
    public function markAs($status)
    {
        $this->update(['status' => $status]);
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function path()
    {
        return "/orders/{$this->uid}";
    }
}
