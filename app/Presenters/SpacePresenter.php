<?php

namespace App\Presenters;

use App\Support\Money;
use Cratespace\Preflight\Presenters\Presenter;

class SpacePresenter extends Presenter
{
    /**
     * Get mutated total price amount attribute.
     *
     * @return string
     */
    public function price(): string
    {
        return Money::format(static::$model->price + static::$model->tax);
    }
}
