<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Model;

abstract class Query
{
    /**
     * Instance of model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected static $model;

    /**
     * Instantiate the model to be queried.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected static function model(): Model
    {
        return app()->make(static::$model);
    }
}