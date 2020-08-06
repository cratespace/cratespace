<?php

namespace App\Presenters;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
    /**
     * Model being used for presentation.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create new view presenter instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Show method as property if property does not exist.
     *
     * @param  string $property
     * @return \Closure
     *
     * @throws \InvalidArgumentException
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        return $this->handleExceptionThrow($property);
    }

    /**
     * Throw exception if property or method does not exist in object.
     *
     * @param  string $property
     *
     * @throws \InvalidArgumentException
     */
    protected function handleExceptionThrow($property)
    {
        throw new InvalidArgumentException(sprintf(
            '%s does not respond to the property or method "%s"',
            static::class,
            $property
        ));
    }
}
