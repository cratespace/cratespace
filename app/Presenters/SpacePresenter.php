<?php

namespace App\Presenters;

use App\Support\Formatter;

class SpacePresenter extends Presenter
{
    /**
     * Calculate and present volume of space.
     *
     * @return int
     */
    public function volume(): int
    {
        return $this->model->height * $this->model->width * $this->model->length;
    }

    /**
     * Get price attribute in money format.
     *
     * @return string
     */
    public function price(): string
    {
        return Formatter::money($this->model->price ?? 0);
    }
}
