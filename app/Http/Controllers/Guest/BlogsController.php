<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    /**
     * Show the Single Blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function single(Blog $blog)
    {
        $comments = $blog->comments()->active()->orderBy('created_at', 'desc')->simplePaginate(1);
        $total_comments = $blog->comments()->active()->count();
        return view('guest/single', ['blog' => $blog, 'comments' => $comments,  'total_comments' => $total_comments]);
    }

    /**
     * Show the blogs by category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $blogs = $category->blogs()->active()->orderBy('created_at', 'desc')->simplePaginate(1);
        return view('guest/category', ['blogs'=> $blogs, 'category' => $category]);
    }
}
