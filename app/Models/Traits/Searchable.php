<?php

namespace App\Models\Traits;

trait Searchable
{
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
                        $query->select('spaces.id')
                            ->from('spaces')
                            ->where('spaces.uid', 'like', $term)
                            ->orWhere('spaces.origin', 'like', $term)
                            ->orWhere('spaces.destination', 'like', $term)
                            ->orWhere('spaces.height', 'like', $term)
                            ->orWhere('spaces.width', 'like', $term)
                            ->orWhere('spaces.length', 'like', $term)
                            ->orWhere('spaces.weight', 'like', $term)
                            ->orWhere('spaces.type', 'like', $term)
                            ->orWhere('spaces.price', 'like', $term)
                            ->orWhere('spaces.departs_at', 'like', $term)
                            ->orWhere('spaces.arrives_at', 'like', $term);
                    }, 'matches');
            });
        });
    }
}
