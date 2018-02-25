<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
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
        return view('guest/single', ['blog' => $blog]);
    }

    /**
     * Show the Single Blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $blogs = Category::simplePaginate(1);
        return view('guest/single', ['blogs' => $blogs]);
    }
}
