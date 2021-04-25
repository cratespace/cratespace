<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

abstract class Eloquent
{
    /**
     * Instance of model being presented.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create new view presenter instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
