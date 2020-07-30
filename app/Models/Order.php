<?php

namespace App\Models;

use App\Models\Traits\Presentable;
use App\Models\Concerns\GeneratesUID;
use App\Models\Concerns\FindsBusiness;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CalculatesCharges;

class Order extends Model
{
    use CalculatesCharges;
    use FindsBusiness;
    use GeneratesUID;
    use Presentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'space_id', 'name', 'email', 'phone', 'business',
        'service', 'price', 'tax', 'total', 'user_id', 'status_id',
    ];

    /**
     * Get all orders associated with the currently authenticated business.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfBusiness($query)
    {
        $query->with('space')
            ->addSelect([
                'status' => Status::select('label')
                    ->whereColumn('status_id', 'statuses.id')
                    ->latest()
                    ->take(1),
            ])
            ->whereUserId(user('id'))
            ->search(request('search'))
            ->latest('updated_at');
    }

    /**
     * Search for orders with given like terms.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string|null                        $terms
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch($query, ?string $terms = null)
    {
        if (is_null($terms)) {
            return $query;
        }

        collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
            $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';

            $query->whereIn('id', function ($query) use ($term) {
                $query->select('id')
                    ->from(function ($query) use ($term) {
                        $query->select('orders.id')
                            ->from('orders')
                            ->where('orders.uid_normalized', 'like', $term)
                            ->orWhere('orders.name_normalized', 'like', $term)
                            ->orWhere('orders.email_normalized', 'like', $term)
                            ->orWhere('orders.phone_normalized', 'like', $term)
                            ->union(
                                $query->newQuery()
                                    ->select('orders.id')
                                    ->from('orders')
                                    ->join('spaces', 'orders.space_id', '=', 'spaces.id')
                                    ->where('spaces.uid_normalized', 'like', $term)
                            );
                    }, 'matches');
            });
        });
    }

    /**
     * Get the current status of the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
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
     * Get the business user associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
