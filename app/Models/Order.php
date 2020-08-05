<?php

namespace App\Models;

use App\Filters\Filter;
use App\Models\Traits\Filterable;
use App\Events\OrderStatusUpdated;
use App\Models\Traits\Presentable;
use App\Models\Concerns\GeneratesUID;
use App\Models\Concerns\FindsBusiness;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CalculatesCharges;
use App\Models\Concerns\GeneratesOrderConfirmationNumber;

class Order extends Model
{
    use GeneratesOrderConfirmationNumber;
    use CalculatesCharges;
    use FindsBusiness;
    use GeneratesUID;
    use Presentable;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'space_id', 'name', 'email', 'phone', 'business',
        'service', 'price', 'tax', 'total', 'user_id', 'status',
        'confirmation_number',
    ];

    /**
     * Find an order using given confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return \App\Models\Order
     */
    public static function findByConfirmationNumber($confirmationNumber)
    {
        return self::where('confirmation_number', $confirmationNumber)->firstOrFail();
    }

    /**
     * Get all orders associated with the currently authenticated business.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param \App\Filters\Filter                $filters
     * @param string|null                        $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeForBusiness($query, Filter $filters, ?string $search = null)
    {
        $query->with('space')
            ->whereUserId(user('id'))
            ->filter($filters)
            ->search($search)
            ->latest('updated_at');
    }

    /**
     * Get given number of latest pending orders.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string|null                        $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePending($query, int $limit = 10)
    {
        $query->whereUserId(user('id'))
            ->select('id', 'uid', 'name', 'phone', 'status', 'total', 'space_id')
            ->with(['space' => function ($query) {
                $query->select('id', 'uid', 'departs_at', 'arrives_at');
            }])
            ->whereStatus('Pending')
            ->latest('created_at');
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
        collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
            $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';

            $query->whereIn('id', function ($query) use ($term) {
                $query->select('id')
                    ->from(function ($query) use ($term) {
                        $query->select('orders.id')
                            ->from('orders')
                            ->where('orders.uid', 'like', $term)
                            ->orWhere('orders.name', 'like', $term)
                            ->orWhere('orders.email', 'like', $term)
                            ->orWhere('orders.phone', 'like', $term)
                            ->union(
                                $query->newQuery()
                                    ->select('orders.id')
                                    ->from('orders')
                                    ->join('spaces', 'orders.space_id', '=', 'spaces.id')
                                    ->where('spaces.uid', 'like', $term)
                            );
                    }, 'matches');
            });
        });
    }

    /**
     * Generate unique confirmation number.
     *
     * @return string
     */
    public function generateConfirmationNumber(): string
    {
        return date('YmdHis') . substr(explode(' ', microtime())[0], 2, 6);
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
     * Get full url to order page.
     *
     * @return string
     */
    public function path(): string
    {
        return route('orders.show', $this);
    }

    /**
     * Update order status.
     *
     * @param string $status
     *
     * @return void
     */
    public function updateStatus(string $status): void
    {
        $this->update(['status' => $status]);

        event(new OrderStatusUpdated($this));
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
