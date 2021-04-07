<?php

namespace App\Models;

use App\Filters\SpaceFilter;
use App\Models\Traits\Orderable;
use App\Models\Casts\ScheduleCast;
use App\Models\Traits\Productable;
use Illuminate\Support\Facades\DB;
use App\Models\Concerns\ManagesProduct;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasEncryptableCode;
use Illuminate\Database\Eloquent\Builder;
use Cratespace\Preflight\Models\Traits\Directable;
use Cratespace\Preflight\Models\Traits\Filterable;
use Cratespace\Preflight\Models\Traits\Presentable;
use App\Contracts\Billing\Product as ProductContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model implements ProductContract
{
    use HasFactory;
    use Filterable;
    use Presentable;
    use Directable;
    use HasEncryptableCode;
    use ManagesProduct;
    use Productable;
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

    /**
     * Get a listing of all available spaces.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function listing(SpaceFilter $filters): Builder
    {
        return static::query()->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereColumn('orders.orderable_id', 'spaces.id');
            })
            ->whereNull('reserved_at')
            ->whereDate('departs_at', '>', now())
            ->filter($filters)
            ->latest('departs_at');
    }
}
