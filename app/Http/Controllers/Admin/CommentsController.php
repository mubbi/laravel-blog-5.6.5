<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:view_all_comment', ['only' => ['index']]);
        $this->middleware('role:view_comment', ['only' => ['show']]);

        $this->middleware('role:moderate_comment', ['only' => ['updateSpamStatus']]);

        $this->middleware('role:delet_comment', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/comments/index');
    }

    /**
     * index comments - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function commentsData()
    {
        $comments = Comment::join('blogs', 'comments.blog_id', '=', 'blogs.id')
                        ->select(['comments.id', 'comments.name', 'comments.email', 'comments.body', 'comments.created_at', 'comments.is_active', 'comments.blog_id', 'blogs.title']);

        return Datatables::of($comments)
                ->editColumn('created_at', function ($model) {
                    return "<abbr title='".$model->created_at->format('F d, Y @ h:i A')."'>".$model->created_at->format('F d, Y')."</abbr>";
                })
                ->editColumn('is_active', function ($model) {
                    if ($model->is_active == 1) {
                        return '<div class="text-danger">No <span class="badge badge-light"><i class="fas fa-times"></i></span></div>';
                    } else {
                        return '<div class="text-success">Yes <span class="badge badge-light"><i class="fas fa-check"></i></span></div>';
                    }
                })
                ->addColumn('blogTitle', function ($model) {
                    return '<a href="' . route("blogs.show", $model->blog_id) . '">' . $model->title . ' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('author', function ($model) {
                    return $model->name . "<br>" . $model->email;
                })
                ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
                ->addColumn('actions', function ($model) {
                    if ($model->is_active == 1) {
                        $spam_action = '<a class="dropdown-item" href="'.route('comments.spamStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-bug"></i> Mark Spam</a>';
                    } else {
                        $spam_action = '<a class="dropdown-item" href="'.route('comments.spamStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-comment"></i> Not Spam</a>';
                    }
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('comments.show', $model->id).'"><i class="fas fa-eye"></i> View</a>
                            '.$spam_action.'
                            <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model->id.'\', \'comments\');"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','bulkAction', 'blogTitle', 'is_active', 'author','created_at'])
                ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin/comments/show', ['comment' => $comment]);
    }

    /**
     * Update the is spam status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSpamStatus($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->is_active == 0) {
            $comment->is_active = 1;
        } else {
            $comment->is_active = 0;
        }
        $status = $comment->save();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Comment Spam status updated.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Failed to change Spam status. Something went wrong.');
        }
    }

    /**
     * Bulk spam items in the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkSpam(Request $request)
    {
        $arrId = explode(",", $request->ids);
        $comments = Comment::findOrFail($arrId);

        // Update Each Comment
        foreach ($comments as $comment) {
            if ($comment->is_active == 0) {
                $comment->is_active = 1;
            } else {
                $comment->is_active = 0;
            }
            $comment->save();
        }

        return back()->with('custom_success', 'Bulk Spam action completed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the comment by $id
        $comment = Comment::findOrFail($id);

        // permanent delete
        $status = $comment->delete();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Comment has been deleted.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Comment was not deleted. Something went wrong.');
        }
    }

    /**
     * Bulk delete items in the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $arrId = explode(",", $request->ids);
        $status = Comment::destroy($arrId);

        if ($status) {
            // If success
            return back()->with('custom_success', 'Bulk Delete action completed.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Bulk Delete action failed. Something went wrong.');
        }
    }
}
