<?php

namespace App\Presenters;

use App\Support\Formatter;

class UserPresenter extends Presenter
{
    /**
     * Calculate and present volume of space.
     *
     * @return string
     */
    public function creditBalance(): string
    {
        return Formatter::money($this->model->account->credit ?? 0);
    }
}
