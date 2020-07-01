<?php

namespace App\Maintainers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

abstract class Maintainer
{
    /**
     * The name of the resource to be collected.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new maintainer instance.
     *
     * @param string $key
     *
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Run maintenance on resource.
     */
    abstract public function run();

    /**
     * Get all entries of model from database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getResource()
    {
        try {
            return DB::table($this->key)->get();
        } catch (Exception $th) {
            return collect([]);
        }
    }
}
