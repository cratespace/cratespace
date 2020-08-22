<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\Presentable;
use App\Models\Traits\Redirectable;
use App\Models\Concerns\ManagesStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Presentable;
    use Filterable;
    use Redirectable;
    use ManagesStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_id',
        'name',
        'email',
        'phone',
        'business',
        'service',
        'price',
        'tax',
        'subtotal',
        'total',
        'user_id',
        'status',
        'confirmation_number',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'confirmation_number';
    }

    /**
     * Create new charge details.
     *
     * @param array $data
     *
     * @return \App\Models\Charge
     */
    public function saveChargeDetails(array $data): Charge
    {
        return $this->charge()->create($data);
    }

    /**
     * Make associated space available again and delete instance.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->space->release();

        $this->delete();
    }

    /**
     * Get the space associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    /**
     * Get the charge associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function charge()
    {
        return $this->hasOne(Charge::class, 'order_id');
    }

    /**
     * Get the business user associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
