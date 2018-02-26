<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the Blogs Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::active()->orderBy('created_at', 'desc')->simplePaginate(1);
        return view('guest/home', ['blogs' => $blogs]);
    }
}
