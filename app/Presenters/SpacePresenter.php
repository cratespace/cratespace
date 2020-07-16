<?php

namespace App\Presenters;

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
}
