<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Feeds extends Controller
{
    public function index()
    {
        /* create new feed */
        $feed = App::make("feed");
        /* creating rss feed with our most recent 20 posts */
        $posts = \DB::table('posts')->orderBy('created_at', 'desc')->take(20)->get();

        /* set your feed's title, description, link, pubdate and language */
        $feed->title = 'Laravel Blog';
        $feed->description = 'Sample Tutorial Blog';
        $feed->logo = url('assets/images/logo.jpg');
        $feed->link = url('feed');
        $feed->setDateFormat('datetime');
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = 'en';
        $feed->setShortening(true);
        $feed->setTextLimit(100);

        foreach ($posts as $post) {
            $feed->add(
                $post->title,
                $post->author,
                URL::to($post->slug),
                $post->created_at,
                $post->description,
                $post->content
            );
        }

        return $feed->render('atom');
    }
}
