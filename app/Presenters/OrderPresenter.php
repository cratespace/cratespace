<?php

namespace App\Presenters;

use App\Support\Formatter;

class OrderPresenter extends Presenter
{
    /**
     * Calculate and present volume of space.
     *
     * @return string
     */
    public function total(): string
    {
        return Formatter::moneyFormat($this->model->total);
    }
}
