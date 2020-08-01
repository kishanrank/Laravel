<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;
use Illuminate\Support\Facades\Validator;

class SettingController extends ResponserController
{
    public function index()
    {
        return view('admin.settings.settings', ['settings' => Setting::firstOrFail()]);
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
            return $this->errorMessageResponse($error->errors()->all());
        }

        $setting_data = [
            'site_name'    =>  $request->site_name,
            'address'     =>  $request->address,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email
        ];
        $setting = Setting::first()->update($setting_data);
        if (!$setting) {
            return $this->errorMessageResponse('Error in updating settings.');
        }
        return $this->successMessageResponse('Setting data successfully updated.');
    }
}
