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
        return $this->formatMoney($this->model->price);
    }

    /**
     * Get tax attribute in money format.
     *
     * @return string
     */
    public function tax(): string
    {
        return $this->formatMoney($this->model->tax);
    }

    /**
     * Convert given amount from cents to money format.
     *
     * @param int $amount
     *
     * @return string
     */
    protected function formatMoney(?int $amount = null): string
    {
        return Formatter::money($amount ?? 0);
    }
}
