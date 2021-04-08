<?php

namespace App\Mail;

class OrderPlacedSuccessfully extends OrderMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
