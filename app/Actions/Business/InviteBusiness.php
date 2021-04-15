<?php

namespace App\Actions\Business;

use App\Models\User;
use App\Models\Invitation;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Cratespace\Sentinel\Http\Requests\Traits\InputValidationRules;

class InviteBusiness
{
    use InputValidationRules;

    /**
     * Preform certain action using the given data.
     *
     * @param array[] $data
     *
     * @return \App\Models\Invitation
     */
    public function invite(User $user): Invitation
    {
        $this->validate($user);

        $invitation = $user->invite();

        Mail::to($user->email)->send(
            new BusinessInvitation($invitation)
        );

        return $invitation;
    }

    /**
     * Validate the invite member operation.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function validate(User $user): void
    {
        Validator::make([
            'email' => $user->email,
            'role' => $user->roles->first()->name,
        ], $this->getRulesFor('invitation'), [
            'email.unique' => __('This business user has already been invited to Cratespace.'),
        ])->after(function ($validator) use ($user) {
            $validator->errors()->addIf(
                $user->invited(),
                'email',
                __('This user has already been invited.')
            );
        })->validateWithBag('addBusiness');
    }
}
