<?php

namespace App\Presenters;

use App\Presenters\Traits\FormatsMoney;

class OrderPresenter extends Presenter
{
    use FormatsMoney;

    /**
     * Calculate and present price in money format.
     *
     * @return string
     */
    public function price(): string
    {
        return $this->formatMoney($this->model->price);
    }

    /**
     * Calculate and present tax in money format.
     *
     * @return string
     */
    public function tax(): string
    {
        return $this->formatMoney($this->model->tax);
    }

    /**
     * Calculate and present service charges in money format.
     *
     * @return string
     */
    public function service(): string
    {
        return $this->formatMoney($this->model->service);
    }

    /**
     * Calculate and present subtotal in money format.
     *
     * @return string
     */
    public function subtotal(): string
    {
        return $this->formatMoney($this->model->subtotal);
    }

    /**
     * Calculate and present total in money format.
     *
     * @return string
     */
    public function total(): string
    {
        return $this->formatMoney($this->model->total);
    }

    /**
     * Get text and color of status badge.
     *
     * @return array
     */
    public function status(): array
    {
        switch ($this->model->status) {
            case 'Pending':
                return [
                    'text' => 'Pending',
                    'color' => 'yellow',
                ];

                break;

            case 'Approved':
                return [
                    'text' => 'Approved',
                    'color' => 'teal',
                ];

                break;

            case 'Shipped':
                return [
                    'text' => 'Shipped',
                    'color' => 'blue',
                ];

                break;

            case 'Delivered':
                return [
                    'text' => 'Delivered',
                    'color' => 'green',
                ];

                break;

            case 'Rejected':
                return [
                    'text' => 'Rejected',
                    'color' => 'red',
                ];

                break;
        }
    }
}
