<?php

namespace App\Models;

use App\Models\Concerns\GeneratesUID;
use App\Models\Concerns\FindsBusiness;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CalculatesCharges;

class Order extends Model
{
    use CalculatesCharges;
    use FindsBusiness;
    use GeneratesUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'space_id', 'name', 'email', 'phone', 'business',
        'service', 'price', 'tax', 'total', 'user_id',
    ];

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
     * Get the business user associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
