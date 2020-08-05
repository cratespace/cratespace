<?php

namespace App\Models\Traits;

use App\Support\Model as ModelHelpers;
use Illuminate\Database\Query\Builder;

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

        collect($this->getTerms($terms))->filter()
            ->each(function ($term) use ($query) {
                $term = $this->parseTerm($term);

                $query->whereIn('id', function ($query) use ($term) {
                    $query->select('id')->from(function ($query) use ($term) {
                        $query = $this->performSubQuery($query);

                        $this->applyWhereQueries($query, $term);
                    }, 'matches');
                });
            });
    }

    /**
     * Get list of terms to be searched with.
     *
     * @param string $terms
     *
     * @return array
     */
    protected function getTerms(string $terms): array
    {
        return str_getcsv($terms, ' ', '"');
    }

    /**
     * Parse given term appropriate for fuzzy searching.
     *
     * @param string $term
     *
     * @return string
     */
    protected function parseTerm(string $term): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';
    }

    /**
     * Perform sub-query on query builder.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function performSubQuery(Builder $query): Builder
    {
        return $query->select($this->getResourceName() . '.id')
            ->from($this->getResourceName());
    }

    /**
     * Apply "orWhere" clause query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $term
     *
     * @return void
     */
    protected function applyWhereQueries(Builder $query, string $term): void
    {
        foreach ($this->getSearchableColumns() as $columns) {
            $query->orWhere("'{$this->getResourceName()}.{$columns}'", 'like', $term);
        }
    }

    /**
     * Get names of columns set to to be searched.
     *
     * @return array
     */
    protected function getSearchableColumns(): array
    {
        if (isset($this->searchableColumns)) {
            return $this->searchableColumns;
        }

        return ['name'];
    }

    /**
     * Determine the activity type.
     *
     * @return string
     */
    protected function getResourceName()
    {
        return ModelHelpers::getNameInPlural($this);
    }
}
