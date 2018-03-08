<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('role:manage_settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::get();
        return view('admin/settings/index', ['settings' => $settings]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validations
        $validatedData = $request->validate([
            'settings.*' => 'required',
        ]);

        // If validations fail
        if (!$validatedData) {
            return redirect()->back()
                    ->withErrors($validator)->withInput();
        }

        foreach ($request->settings as $key => $value) {
            // Store the item
            DB::table('settings')
            ->where('setting_name', $key)
            ->update(['setting_value' => $value]);
        }

        // Back to index with success
        return redirect()->back()->with('custom_success', 'Settings has been updated successfully');
    }
}
