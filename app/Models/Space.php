<?php

namespace App\Models;

use App\Models\Traits\Orderable;
use App\Models\Traits\Directable;
use App\Models\Traits\Filterable;
use App\Models\Casts\ScheduleCast;
use App\Models\Traits\Presentable;
use App\Models\Concerns\ManagesProduct;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasEncryptableCode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Contracts\Products\Product as ProductContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model implements ProductContract
{
    use HasFactory;
    use Filterable;
    use Presentable;
    use Directable;
    use HasEncryptableCode;
    use ManagesProduct;
    use Orderable;

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
        'code',
        'departs_at',
        'arrives_at',
        'reserved_at',
        'destination',
        'origin',
        'height',
        'width',
        'length',
        'weight',
        'note',
        'price',
        'tax',
        'user_id',
        'type',
        'base',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reserved_at' => 'datetime',
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
