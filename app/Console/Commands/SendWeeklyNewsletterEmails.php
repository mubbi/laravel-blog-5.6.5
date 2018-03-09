<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Subscriber;
use App\Jobs\SendWeeklyNewsletterEmail;
use App\Listeners\WeeklyNewsletterEmailListener;

class SendWeeklyNewsletterEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It sends weekly newsletter to the active subscribers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Subscriber::orderBy('id')->active()->chunk(100, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                // Automatic Weekly Newsletter
                event(new WeeklyNewsletterEmailListener($subscriber));
                SendWeeklyNewsletterEmail::dispatch($subscriber);
            }
        });
    }
}
