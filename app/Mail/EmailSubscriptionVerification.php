<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSubscriptionVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscription-confrimation', [
            'email_token' => $this->subscriber->confirmation_token
        ]);
    }
}
