<?php

namespace App\Queries;

use RuntimeException;
use App\Support\Eloquent;
use Illuminate\Database\Eloquent\Model;

class Query extends Eloquent
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
