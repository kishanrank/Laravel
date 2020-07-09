<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use App\Http\Controllers\ResponserController;
use Illuminate\Http\Request;

class InboxController extends ResponserController
{
    public function index() 
    {
    	$messages = ContactUs::all();
    	return view('admin.inbox.index', compact('messages'));
    }

    public function show($id) 
    {
    	$message = ContactUs::findOrFail($id);
        if ($message == null) {
            return $this->errorMessageResponse('Error in finding data, please try after sometime.');
        }

    	return response()->json(['result' => $message]);
    }

}
