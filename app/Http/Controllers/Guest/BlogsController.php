<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
use App\Category;
use App\Comment;
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

    /**
     * Add comment on a blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        // Validate data
        $validatedData = $request->validate([
            'name' => 'bail|required|max:150',
            'email' => 'required|email',
            'body' => 'required|max:600',
        ]);

        // Get Blog by slug
        $blog_slug = explode('/', url()->previous());
        $blog = Blog::where('slug', end($blog_slug))->select('id')->firstOrFail();

        // If blog found
        if (!empty($blog)) {
            // Check status of validation
            if ($validatedData) {
                // Save Comment
                $comment = new Comment;
                $comment->name = $request->name;
                $comment->email = $request->email;
                $comment->body = $request->body;
                $comment->blog_id = $blog->id;
                $comment->save();

                // Redirect back with success
                return back()->with('success', 'Your comment added successfully');
            }
        }
        // Redirect back with error
        return back()->withInput()->with('errors', 'Unable to add comment');
    }
}
