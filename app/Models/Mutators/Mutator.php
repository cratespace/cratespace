<?php

namespace App\Models\Mutators;

use Illuminate\Database\Eloquent\Model;

abstract class Mutator
{
    /**
     * Instance of model's attributes to be mutated.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create new model attribute mutator.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
