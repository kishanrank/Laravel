<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.settings', ['settings' => Setting::first()]);
    }

    public function update(Request $request)
    {
        $rules = [
            'site_name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'contact_email' => 'required' 
        ];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        $setting_data = [
            'site_name'    =>  $request->site_name,
            'address'     =>  $request->address,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email
        ];
        $setting = Setting::first()->update($setting_data);
        if (!$setting) {
            return response()->json(['error' => 'Error in updating settings.']);
        }
        return response()->json(['success' => 'Setting data successfully updated.']);
    }
}
