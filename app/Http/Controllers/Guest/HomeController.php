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
        $blogs = Blog::active()->orderBy('created_at', 'desc')
                            ->simplePaginate(app('global_settings')[2]['setting_value']);
        return view('guest/home', ['blogs' => $blogs]);
    }
    /**
     * Show the Blogs Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        // Validate data
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        if ($validatedData) {
            // Save Subscriber
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $comment->save();

            // Redirect back with success
            return back()->with('success', 'Check your Email for Confirnmation');
        }
        // Redirect back with error
        return back()->withInput()->with('errors', 'Unable to Subscribe');
    }
}
