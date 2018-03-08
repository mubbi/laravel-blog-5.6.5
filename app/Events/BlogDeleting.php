<?php

namespace App\Events;

use App\Blog;
use App\Events\Event;

class BlogDeleting
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
        // Delet Blog Categories
        $this->blog->categories()->detach();
        $this->blog->comments()->delete();
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
