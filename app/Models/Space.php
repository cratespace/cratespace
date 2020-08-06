<?php

namespace App\Models;

use App\Models\Traits\Indexable;
use App\Models\Traits\Filterable;
use App\Models\Casts\ScheduleCast;
use App\Models\Traits\Presentable;
use App\Models\Traits\Redirectable;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use Filterable;
    use Presentable;
    use Redirectable;
    use Indexable;

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
        'uid',
        'departs_at',
        'arrives_at',
        'origin',
        'destination',
        'height',
        'width',
        'length',
        'weight',
        'note',
        'price',
        'tax',
        'user_id',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
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
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
