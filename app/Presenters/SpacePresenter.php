<?php

namespace App\Presenters;

use App\Support\Money;
use Cratespace\Preflight\Presenters\Presenter;

class SpacePresenter extends Presenter
{
    /**
     * Get mutated price attribute.
     *
     * @return string
     */
    public function price(): string
    {
        return Money::format($this->model->price + $this->model->tax);
    }
}
