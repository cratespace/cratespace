<?php

namespace App\Contracts;

interface Searchable
{
    /**
     * Returns database driver Ex: mysql, pgsql, sqlite.
     *
     * @return array
     */
    public function getDatabaseDriver();

    /**
     * Returns the sql string for the given parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $column
     * @param string $relevance
     * @param array $words
     * @param string $compare
     * @param float $relevanceMultiplier
     * @param string $preWord
     * @param string $postWord
     * @return string
     */
    public function getSearchQuery(Builder $builder, $column, $relevance, array $words, $relevanceMultiplier, $preWord = '', $postWord = '');
}
