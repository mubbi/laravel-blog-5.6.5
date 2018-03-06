<?php

namespace App\Http\Controllers\Guest;

use App\Blog;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendSubscriptionVerificationEmail;
use App\Listeners\EmailSubscribedListener;

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
            'email' => 'required|email|unique:subscribers'
        ]);

        if ($validatedData) {
            // Save Subscriber
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->confirmation_token = md5(uniqid($request->email, true));
            $subscriber->save();
            // Automatic Send Email for confirmation
            event(new EmailSubscribedListener($subscriber));
            SendSubscriptionVerificationEmail::dispatch($subscriber);
            // Return Success Message
            return response()->json('Check Your Email Inbox for confirmation', 200);
        }
        // return error
        return response()->json('Unable to Subscribe', 422);
    }

    public function subscribeVerify($token)
    {
        $subscriber = Subscriber::where('confirmation_token', $token)->first();
        $subscriber->is_active = 1;
        if ($subscriber->save()) {
            return view('guest.subscribe-confirmation', ['subscriber' => $subscriber]);
        }
    }
}
