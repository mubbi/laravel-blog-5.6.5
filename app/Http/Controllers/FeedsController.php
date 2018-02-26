<?php

namespace App\Http\Controllers;

use App;
use URL;
use App\Blog;
use Illuminate\Http\Request;

class FeedsController extends Controller
{
    public function index()
    {
        /* create new feed */
        $feed = App::make("feed");

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(60, 'laravelBlogFeedCacheKey');

        /* creating rss feed with our most recent 10 posts */
        $posts = Blog::active()->orderBy('created_at', 'desc')->take(10)->get();

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
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

            // set item's title, author, url, pubdate, description, content, enclosure (optional)*
            foreach ($posts as $post) {
                $feed->add(
                    $post->title,
                    $post->user_id,
                    URL::to('post/'.$post->slug),
                    $post->created_at,
                    $post->excerpt,
                    $post->description
                );
            }
        }


        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        return $feed->render('atom');

        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }
}
