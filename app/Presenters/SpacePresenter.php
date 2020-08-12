<?php

namespace App\Presenters;

use App\Models\Business;
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
     * Get tax attribute in money format.
     *
     * @return string
     */
    public function fullPrice(): string
    {
        return $this->formatMoney($this->model->price + $this->model->tax);
    }

    /**
     * Get the name of the business the space is associated with.
     *
     * @return string
     */
    public function businessName()
    {
        return Business::select('name')
            ->whereUserId($this->model->user_id)
            ->first()
            ->name;
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
