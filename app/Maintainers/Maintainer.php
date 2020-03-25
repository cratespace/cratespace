<?php

namespace App\Maintainers;

use Illuminate\Database\Eloquent\Model;

abstract class Maintainer
{
    /**
     * The resource model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new maintainer instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
        return $this->model->all();
    }
}
