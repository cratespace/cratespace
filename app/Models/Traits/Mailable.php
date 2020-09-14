<?php

namespace App\Models\Traits;

use RuntimeException;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\NoEmailAddressSetException;
use Illuminate\Contracts\Mail\Mailable as MailableContract;

trait Mailable
{
    /**
     * Dispatch given mailable to model email address.
     *
     * @param string      $mailable
     * @param string|null $emailAddress
     *
     * @return void
     */
    public function mail(string $mailable, ?string $emailAddress = null): void
    {
        $email = $this->email ?? ($emailAddress ?: null);

        if (is_null($email)) {
            throw new NoEmailAddressSetException('No email address has been specified.');
        }

        Mail::to($email)->send($this->resolveMailable($mailable));
    }

    /**
     * Resolve given mailable type.
     *
     * @param string $mailable
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    protected function resolveMailable(string $mailable): MailableContract
    {
        $mailable = new $mailable($this);

        if (!$mailable instanceof MailableContract) {
            throw new RuntimeException("{$mailable} is not a valid mailable.");
        }

        return $mailable;
    }
}
