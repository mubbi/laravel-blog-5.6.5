<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:view_all_user', ['only' => ['index', 'usersData']]);
        $this->middleware('role:view_user', ['only' => ['show']]);

        $this->middleware('role:add_user', ['only' => ['create','store']]);

        $this->middleware('role:edit_user', ['only' => ['update', 'edit', 'updateActiveStatus']]);

        $this->middleware('role:delet_user', ['only' => ['destroy', 'bulkDelete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/users/index');
    }

    /**
     * index users - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersData()
    {
        $users = User::select(['id', 'name', 'email', 'is_active', 'created_at']);
        return Datatables::of($users)
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
                ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
                ->addColumn('actions', function ($model) {
                    if ($model->is_active == 0) {
                        $status_action = '<a class="dropdown-item" href="'.route('users.activeStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-check"></i> Activate</a>';
                    } else {
                        $status_action = '<a class="dropdown-item" href="'.route('users.activeStatus', $model->id).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-times"></i> Inactivate</a>';
                    }
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('users.show', $model->id).'"><i class="fas fa-eye"></i> View</a>
                            <a class="dropdown-item" href="'.route('users.edit', $model->id).'"><i class="fas fa-edit"></i> Edit</a>
                            '.$status_action.'
                            <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model->id.'\', \'users\');"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','is_active','bulkAction','created_at'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validations
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'about' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // If validations fail
        if (!$validatedData) {
            return redirect()->back()
                    ->withErrors($validator)->withInput();
        }

        // Store the item
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->about = $request->about;
        $user->is_active = $request->is_active;
        $user->confirmation_token = md5(uniqid($request->email, true));
        $user->save();

        // Back to index with success
        return redirect()->route('users.index')->with('custom_success', 'User has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin/users/show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // User Details
        $user = User::findOrFail($id);
        return view('admin/users/edit', ['user' => $user]);
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
        // Validations
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'about' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // If validations fail
        if (!$validatedData) {
            return redirect()->back()
                    ->withErrors($validator)->withInput();
        }

        // Get the item to update
        $user = User::findOrFail($id);

        // Prevent user from updating a super admin
        if ($user->hasRole('super_admin')) {
            // if logged in user dont have Super Admin Role stop him
            if (!Auth::user()->hasRole('super_admin')) {
                return back()->with('custom_errors', 'User can not be updated. You need super admin role.');
            }
        }

        // Update the item
        $user->name = $request->name;
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        } else {
            $user->password = $user->password;
        }
        $user->about = $request->about;
        $user->is_active = $request->is_active;
        $user->save();

        // Back to index with success
        return back()->with('custom_success', 'User has been updated successfully');
    }

    /**
     * Update the is active status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateActiveStatus($id)
    {
        // get user
        $user = User::findOrFail($id);

        // Prevent user from self deactivating
        if ($user->id == Auth::user()->id) {
            return back()->with('custom_errors', 'You can not deactive yourself. Ask super admin to do that.');
        }

        // Prevent user from deactivating a super admin
        if ($user->hasRole('super_admin')) {
            // if logged in user dont have Super Admin Role stop him
            if (!Auth::user()->hasRole('super_admin')) {
                return back()->with('custom_errors', 'User can not be deactived. You need super admin role.');
            }
        }

        if ($user->is_active == 0) {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }
        $status = $user->save();

        if ($status) {
            // If success
            return back()->with('custom_success', 'User active status updated.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Failed to change User active status. Something went wrong.');
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
        // Find the user by $id
        $user = User::findOrFail($id);

        // Prevent user from self deleting
        if ($user->id == Auth::user()->id) {
            return back()->with('custom_errors', 'You can not delete yourself. Ask super admin to do that.');
        }

        // Prevent user from deleting a super admin
        if ($user->hasRole('super_admin')) {
            // if logged in user dont have Super Admin Role stop him
            if (!Auth::user()->hasRole('super_admin')) {
                return back()->with('custom_errors', 'User can not be deleted. You need super admin role.');
            }
        }

        // delete
        $status = $user->delete();

        if ($status) {
            // If success
            return back()->with('custom_success', 'User has been deleted');
        } else {
            // If no success
            return back()->with('custom_errors', 'User was not deleted. Something went wrong.');
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
        $status = User::destroy($arrId);

        if ($status) {
            // If success
            return back()->with('custom_success', 'Bulk Delete action completed.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Bulk Delete action failed. Something went wrong.');
        }
    }
}
