<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    /**
     * Show the Single Blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function single(Blog $blog)
    {
        // Increase Views of blog
        $blog->views = $blog->views + 1;
        $blog->save();

        // Get Comments
        $comments = $blog->comments()->active()
                                    ->orderBy('created_at', 'desc')
                                    ->simplePaginate(app('global_settings')[3]['setting_value']);
        // Get Count of Comments
        $total_comments = $blog->comments()->active()->count();

        // Return View
        return view('guest/single', ['blog' => $blog, 'comments' => $comments,  'total_comments' => $total_comments]);
    }

    /**
     * Show the blogs by category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $blogs = $category->blogs()->active()
                                ->orderBy('created_at', 'desc')
                                ->simplePaginate(app('global_settings')[2]['setting_value']);
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
                return back()->with('custom_success', 'Your comment added successfully');
            }
        }
        // Redirect back with error
        return back()->withInput()->with('custom_errors', 'Unable to add comment');
    }


    /**
     * Search the blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Search Query
        $query = $request->q;
        if ($query == '') {
            return redirect('/');
        }

        // Get blogs by Search Query and active ones
        $blogs = Blog::like('title', $query)
                        ->orLike('excerpt', $query)
                        ->active()
                        ->orderBy('created_at', 'desc')
                        ->simplePaginate(app('global_settings')[2]['setting_value']);
        // Return View
        return view('guest/search', ['blogs' => $blogs, 'query' => $query]);
    }
}
