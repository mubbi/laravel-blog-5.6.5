<?php

namespace App\Events;

use App\Blog;
use App\Events\Event;
use Illuminate\Support\Facades\Storage;

class BlogDeleted
{
    public $blog;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
        // Delet Blog Image
        Storage::delete($this->blog->image);
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
    }
}
