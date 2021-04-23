<?php

namespace Tests\Fixtures;

use App\Presenters\Presenter;

class MockPresenter extends Presenter
{
    public function foobar(): string
    {
        return ucfirst($this->model->foo);
    }
}
