<?php

namespace App\Jobs;

use Mail;
use App\Blog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\WeeklyNewsletterEmail;

class SendWeeklyNewsletterEmail implements ShouldQueue
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
        // Last 7 Days
        $date = new Carbon;
        $date->subWeek();

        // Get Blogs
        $blogs = Blog::orderBy('id', 'desc')
                        ->active()
                        ->where('created_at', '>=', $date->toDateTimeString())
                        ->get();

        // If there are new blogs in last week
        if (count($blogs) > 0) {
            // Generate Email
            $email = new WeeklyNewsletterEmail($this->subscriber, $blogs);
            // Send Email
            Mail::to($this->subscriber->email)->send($email);
        }
    }
}
