<?php

namespace App\Http\Controllers\Front;

use App\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index() {
    	return view('front.contactus.index');
    }

    public function store(Request $request) 
    {
    	if (!($request->all())) {
            return response()->json(['error' => "Error in submitting"]);
        }
        $rules = [
        	'email' => 'required|email', 
        	'subject' => 'required',
        	'message' => 'required'
        ];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        $query_data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'message' =>$request->message
        ];
        $query_message = ContactUs::create($query_data);
        if (!$query_data) {
            return response()->json(['error' => "Error in submitting in response."]);
        }
        return response()->json(['success' => 'Thanks for contacting us. We will get back to you as soon as possible.']);
    }
}
