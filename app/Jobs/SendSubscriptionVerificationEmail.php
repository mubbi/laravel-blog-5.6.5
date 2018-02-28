<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\EmailSubscriptionVerification;

class SendSubscriptionVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailSubscriptionVerification($this->subscriber);
        Mail::to($this->subscriber->email)->send($email);
    }
}
