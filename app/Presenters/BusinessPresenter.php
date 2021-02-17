<?php

namespace App\Presenters;

class BusinessPresenter extends Presenter
{
    /**
     * Get full address of business.
     *
     * @return string
     */
    public function address(): string
    {
        return "{$this->model->street}, {$this->model->city}, {$this->model->state}, {$this->model->country}, {$this->model->postcode}";
    }
}
