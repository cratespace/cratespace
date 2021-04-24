<?php

namespace App\Queries;

use RuntimeException;
use Illuminate\Database\Eloquent\Model;

abstract class Query
{
    /**
     * Create a new model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model(): Model
    {
        if (is_null($this->model)) {
            throw new RuntimeException();
        }

        return app($this->model);
    }
}
