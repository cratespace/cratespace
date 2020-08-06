<?php

namespace App\Reports\Query;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder
{
    /**
     * Table name to query from.
     *
     * @var string
     */
    protected $key;

    /**
     * Determine if the query building is contrained to authenticated user.
     *
     * @var bool
     */
    protected $forAuthUser = false;

    /**
     * Create report builder instance.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Set report builder constrains for authenticated user.
     *
     * @return void
     */
    public function setForAuthurizedOnly(): void
    {
        $this->forAuthUser = true;
    }

    /**
     * Get report query build instacne.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function build(): QueryBuilder
    {
        if ($this->forAuthUser) {
            return $this->getFacade()->where('user_id', user('id'));
        }

        return $this->getFacade();
    }

    /**
     * Get database manager facade instance.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getFacade(): QueryBuilder
    {
        return DB::table($this->key);
    }
}
