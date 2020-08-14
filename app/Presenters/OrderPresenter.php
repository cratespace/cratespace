<?php

namespace App\Presenters;

use App\Support\Formatter;

class OrderPresenter extends Presenter
{
    /**
     * Calculate and present price in money format.
     *
     * @return string
     */
    public function price(): string
    {
        return Formatter::money($this->model->price);
    }

    /**
     * Calculate and present tax in money format.
     *
     * @return string
     */
    public function tax(): string
    {
        return Formatter::money($this->model->tax);
    }

    /**
     * Calculate and present service charges in money format.
     *
     * @return string
     */
    public function service(): string
    {
        return Formatter::money($this->model->service);
    }

    /**
     * Calculate and present subtotal in money format.
     *
     * @return string
     */
    public function subtotal(): string
    {
        return Formatter::money($this->model->subtotal);
    }

    /**
     * Calculate and present total in money format.
     *
     * @return string
     */
    public function total(): string
    {
        return Formatter::money($this->model->total);
    }
}
