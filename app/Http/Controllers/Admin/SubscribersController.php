<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class SubscribersController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:view_all_subscriber', ['only' => ['index','subscribersData']]);

        $this->middleware('role:edit_subscriber', ['only' => ['updateActiveStatus']]);

        $this->middleware('role:delet_subscriber', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/subscribers/index');
    }

    /**
     * index subscribers - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribersData()
    {
        $subscribers = Subscriber::select(['id', 'email', 'is_active', 'created_at']);

        return Datatables::of($subscribers)
                ->editColumn('created_at', function ($model) {
                    return "<abbr title='".$model->created_at->format('F d, Y @ h:i A')."'>".$model->created_at->format('F d, Y')."</abbr>";
                })
                ->editColumn('is_active', function ($model) {
                    if ($model->is_active == 0) {
                        return '<div class="text-danger">No <span class="badge badge-light"><i class="fas fa-times"></i></span></div>';
                    } else {
                        return '<div class="text-success">Yes <span class="badge badge-light"><i class="fas fa-check"></i></span></div>';
                    }
                })
                ->addColumn('actions', function ($model) {
                    if ($model->is_active == 0) {
                        $active_action = '<a class="dropdown-item" href="'.route('subscribers.activeStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-check"></i> Activate</a>';
                    } else {
                        $active_action = '<a class="dropdown-item" href="'.route('subscribers.activeStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-times"></i> Inactivate</a>';
                    }
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            '.$active_action.'
                            <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model->id.'\', \'subscribers\');"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','created_at', 'is_active'])
                ->make(true);
    }

    /**
     * Update the is active status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateActiveStatus($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        if ($subscriber->is_active == 0) {
            $subscriber->is_active = 1;
        } else {
            $subscriber->is_active = 0;
        }
        $status = $subscriber->save();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Subscriber Active status updated.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Failed to change active status. Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the subscriber by $id
        $subscriber = Subscriber::findOrFail($id);

        // delete
        $status = $subscriber->delete();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Subscriber has been deleted.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Subscriber was not deleted. Something went wrong.');
        }
    }
}
