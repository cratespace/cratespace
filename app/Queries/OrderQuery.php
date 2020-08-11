<?php

namespace App\Queries;

use App\Models\Order;
use App\Filters\Filter;

class OrderQuery extends Query
{
    /**
     * Instance of model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected static $model = Order::class;

    /**
     * Find an order using given confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return \App\Models\Order
     */
    public static function findByConfirmationNumber(string $confirmationNumber)
    {
        return static::model()->query()
            ->where('confirmation_number', $confirmationNumber)
            ->firstOrFail();
    }

    /**
     * Get all orders associated with the currently authenticated business.
     *
     * @param \App\Filters\Filter $filters
     * @param string|null         $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function forBusiness(Filter $filters, ?string $search = null)
    {
        return static::model()->query()
            ->with('space')
            ->whereUserId(user('id'))
            ->filter($filters)
            ->latest('updated_at');
    }

    /**
     * Get given number of latest pending orders.
     *
     * @param int $limit
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function pending(int $limit = 10)
    {
        return static::model()->query()
            ->whereUserId(user('id'))
            ->select('id', 'confirmation_number', 'name', 'phone', 'status', 'total', 'space_id')
            ->with(['space' => function ($query) {
                $query->select('id', 'uid', 'departs_at', 'arrives_at');
            }])
            ->whereStatus('Pending')
            ->take($limit)
            ->latest('created_at');
    }

    /**
     * Search for orders with given like terms.
     *
     * @param string|null $terms
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function search(?string $terms = null)
    {
        $query = static::model()->query();

        collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
            $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';

            $query->whereIn('id', function ($query) use ($term) {
                $query->select('id')
                    ->from(function ($query) use ($term) {
                        $query->select('orders.id')
                            ->from('orders')
                            ->where('orders.confirmation_number', 'like', $term)
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
}
