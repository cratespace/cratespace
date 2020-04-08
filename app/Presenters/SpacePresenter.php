<?php

namespace App\Presenters;

class SpacePresenter extends Presenter
{
    /**
     * Get indformation of business the space isassociated with.
     *
     * @return \App\Models\Profile
     */
    public function business()
    {
        return $this->model->user->business;
    }
}
