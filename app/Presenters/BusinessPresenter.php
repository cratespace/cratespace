<?php

namespace App\Presenters;

use App\Support\Money;
use Cratespace\Preflight\Presenters\Presenter;

class BusinessPresenter extends Presenter
{
    /**
     * Get full address of business.
     *
     * @return string
     */
    public function address(): string
    {
        return sprintf(
            '%s, %s, %s, %s, %s',
            static::$model->street,
            static::$model->city,
            static::$model->state,
            static::$model->country,
            static::$model->postcode
        );
    }

    /**
     * Mutate credit value to proper presentable money format.
     *
     * @return string
     */
    protected function credit(): string
    {
        return Money::format(static::$model->credit);
    }
}
