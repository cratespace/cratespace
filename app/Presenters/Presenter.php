<?php

namespace App\Presenters;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

abstract class Presenter
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

    /**
     * Show method as property if property does not exist.
     *
     * @param string $property
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        throw new InvalidArgumentException(sprintf('%s does not respond to the property or method "%s"', static::class, $property));
    }
}
