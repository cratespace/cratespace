<?php

namespace App\Presenters;

use App\Support\Money;
use App\Contracts\Billing\Product;

class SpacePresenter extends Presenter
{
    /**
     * Get mutated price attribute.
     *
     * @return string
     */
    public function price(): string
    {
        if ($this->model instanceof Product) {
            $amount = $this->model->fullAmount();
        } else {
            $amount = $this->model->price + ($this->model->tax ?? 0);
        }

        return Money::format($amount);
    }
}
