<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyNewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $subscriber;
    protected $blogs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $blogs)
    {
        $this->subscriber = $subscriber;
        $this->blogs = $blogs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.weekly-newsletter', [
            'blogs' => $this->blogs
        ]);
    }
}
