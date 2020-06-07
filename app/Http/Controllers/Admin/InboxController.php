<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
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
            return response()->json(['error' => 'Error in finding data, please try after sometime.']);
        }
    	return response()->json(['result' => $message]);
    }

}
