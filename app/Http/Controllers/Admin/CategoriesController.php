<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:view_all_category', ['only' => ['index']]);
        $this->middleware('role:view_category', ['only' => ['show']]);

        $this->middleware('role:moderate_category', ['only' => ['edit']]);
        $this->middleware('role:moderate_category', ['only' => ['update']]);

        $this->middleware('role:delet_category', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * index categories - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesData()
    {
        return Datatables::of(Category::query())->make(true);
    }

    /**
     * Select2 categories - Process select2 ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesAjaxSelectData(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $categories = Category::where('name', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('name')
                                    ->skip($offset)
                                    ->take($resultCount)
                                    ->selectRaw('id, name as text')
                                    ->get();

            $count = Count(Category::where('name', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('name')
                                    ->selectRaw('id, name as text')
                                    ->get());

            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;

            $results = array(
                  "results" => $categories,
                  "pagination" => array(
                      "more" => $morePages
                  )
              );

            return response()->json($results);
        }
        return response()->json('oops');
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
