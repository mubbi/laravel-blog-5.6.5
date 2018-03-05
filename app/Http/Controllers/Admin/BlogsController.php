<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:view_all_blog', ['only' => ['index']]);
        $this->middleware('role:view_blog', ['only' => ['show']]);

        $this->middleware('role:add_blog', ['only' => ['create']]);
        $this->middleware('role:add_blog', ['only' => ['store']]);

        $this->middleware('role:edit_blog', ['only' => ['edit']]);
        $this->middleware('role:edit_blog', ['only' => ['update']]);

        $this->middleware('role:delet_blog', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trashed_items = Blog::onlyTrashed()->count();
        return view('admin/blogs/index', ['trashed_items_count' => $trashed_items]);
    }

    /**
     * index blogs - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogsData()
    {
        $blogs = Blog::join('users', 'blogs.user_id', '=', 'users.id')
                        ->select(['blogs.id', 'blogs.title', 'blogs.user_id', 'users.name', 'blogs.created_at']);

        return Datatables::of($blogs)
                ->editColumn('created_at', function ($model) {
                    return $model->created_at->format('F d, Y h:i A');
                })
                ->editColumn('users.name', function ($model) {
                    return '<a href="'.route('users.show', $model->user_id).'" class="link">'.$model->name.' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('actions', function ($model) {
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('blogs.show', $model->id).'"><i class="fas fa-eye"></i> View</a>
                            <a class="dropdown-item" href="'.route('blogs.edit', $model->id).'"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model->id.'\', \'blogs\');"><i class="fas fa-trash"></i> Delet</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','users.name'])
                ->make(true);
    }



    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed_items = Blog::onlyTrashed()->count();
        return view('admin/blogs/trashed-index', ['trashed_items_count' => $trashed_items]);
    }

    /**
     * trashed blogs - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogsAjaxTrashedData()
    {
        $blogs = Blog::join('users', 'blogs.user_id', '=', 'users.id')
                        ->select(['blogs.id', 'blogs.title', 'blogs.user_id', 'users.name', 'blogs.deleted_at'])
                        ->onlyTrashed();

        return Datatables::of($blogs)
                ->editColumn('trashed_at', function ($model) {
                    return $model->deleted_at->format('F d, Y h:i A');
                })
                ->editColumn('users.name', function ($model) {
                    return '<a href="'.route('users.show', $model->user_id).'" class="link">'.$model->name.' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('actions', function ($model) {
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('blogs.restore', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-eye"></i> Restore</a>
                            <a class="dropdown-item text-danger" href="'.route('blogs.permanentDelet', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i> Permanent Delet</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','users.name'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/blogs/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the blog by $id
        $blog = Blog::findOrFail($id);

        // Soft Delet the blog and transfer to Trash Items
        $blog->delete();

        if ($blog->trashed()) {
            // If success
            return back()->with('success', 'Blog has been deleted and transfered to trash items.');
        } else {
            // If no success
            return back()->with('errors', 'Blog was not deleted. Something went wrong.');
        }
    }

    /**
     * Restore the specified resource from trashed storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // Find the blog by $id
        $blog = Blog::onlyTrashed()->findOrFail($id);

        // Restore the blog
        $blog->restore();

        if (!$blog->trashed()) {
            // If success
            return back()->with('success', 'Blog has been restored.');
        } else {
            // If no success
            return back()->with('errors', 'Blog was not able to restore. Something went wrong.');
        }
    }

    /**
     * Permanent Delet the specified resource from trashed storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permanentDelet($id)
    {
        // Find the blog by $id
        $blog = Blog::onlyTrashed()->findOrFail($id);

        // Permanent Delet the blog
        $status =$blog->forceDelete();

        if ($status) {
            // If success
            return back()->with('success', 'Blog has been deleted permanently.');
        } else {
            // If no success
            return back()->with('errors', 'Blog was not able to deleted permanently. Something went wrong.');
        }
    }
}
