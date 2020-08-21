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
     * Get text and color of status badge.
     *
     * @return array
     */
    public function status(): array
    {
        switch (true) {
            case $this->model->isAvailable():
                return [
                    'text' => 'Available',
                    'color' => 'green',
                ];

                break;

            case $this->model->hasOrder():
                return [
                    'text' => 'Ordered',
                    'color' => 'blue',
                ];

                break;

            case $this->model->isExpired():
                return [
                    'text' => 'Expired',
                    'color' => 'gray',
                ];

                break;
        }
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
