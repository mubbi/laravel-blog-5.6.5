<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\User;
use App\Category;
use App\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs_count = Blog::count();
        $comments_count = Comment::count();
        $categories_count = Category::count();
        $users_count = User::count();

        return view('admin/dashboard', [
            'blogs_count' => $blogs_count,
            'comments_count' => $comments_count,
            'categories_count' => $categories_count,
            'users_count' => $users_count,
        ]);
    }
}
