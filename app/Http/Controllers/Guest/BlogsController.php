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
        return view('guest/single', ['blog' => $blog]);
    }

    /**
     * Show the blogs by category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $blogs = Blog::whereHas('categories')->simplePaginate(1);

        return view('guest/category', ['blogs' => $blogs, 'category' => $category]);
    }
}
