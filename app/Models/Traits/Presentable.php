<?php

namespace App\Models\Traits;

use App\Presenters\Presenter;

trait Presentable
{
    /**
     * Get relevant view presenter.
     *
     * @return \App\Presenters\Presenter
     */
    public function present(): Presenter
    {
        $presenter = $this->constructPresenter();

        return new $presenter($this);
    }

    /**
     * Create model view presenter instance.
     *
     * @return string
     */
    protected function constructPresenter(): string
    {
        return 'App\\Presenters\\' . class_basename($this) . 'Presenter';
    }
}
