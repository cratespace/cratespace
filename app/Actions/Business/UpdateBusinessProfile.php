<?php

namespace App\Actions\Business;

use App\Models\User;
use Cratespace\Sentinel\Support\Traits\Fillable;
use Cratespace\Sentinel\Contracts\Actions\UpdatesUserProfiles;

class UpdateBusinessProfile implements UpdatesUserProfiles
{
    use Fillable;

    /**
     * Validate and update the given user's profile information.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function update(User $user, array $data): void
    {
        $user->business->update($this->filterFillable($data, $user->business));
    }
}
