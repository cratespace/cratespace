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
    public function present()
    {
        $presenter = $this->constructPresenter();

        return new $presenter($this);
    }

    /**
     * Create model view presenter instance.
     *
     * @return \App\Presenters\Presenter
     */
    protected function constructPresenter()
    {
        return 'App\\Presenters\\' . class_basename($this) . 'Presenter';
    }
}
