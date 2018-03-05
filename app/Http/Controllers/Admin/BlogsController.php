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
        return view('admin/blogs/index');
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
                ->editColumn('title', '{!! str_limit($title, 60) !!}')
                ->editColumn('created_at', function ($model) {
                    return $model->created_at->format('F d, Y h:i A');
                })
                ->editColumn('users.name', function ($model) {
                    return '<a href="view#'.$model->user_id.'" class="link">'.$model->name.' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('actions', function ($model) {
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.$model->id.'"><i class="fas fa-eye"></i> View</a>
                            <a class="dropdown-item" href="'.$model->id.'"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item text-danger" href="'.$model->id.'"><i class="fas fa-trash"></i> Delet</a>
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
        //
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
        //
    }
}
