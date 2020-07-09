<?php

namespace App\Http\Controllers\Front;

use App\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponserController;
use Illuminate\Http\Request;

class ContactUsController extends ResponserController
{
    public function index() {
    	return view('front.contactus.index');
    }

    public function store(Request $request) 
    {
    	if (!($request->all())) {
            $this->errorMessageResponse('Error in submitting');
        }

        $rules = [
            'name' => 'required',
        	'email' => 'required|email', 
        	'subject' => 'required',
        	'message' => 'required'
        ];

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }

        $query_data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' =>$request->message
        ];

        $query_message = ContactUs::create($query_data);
        if (!$query_data) {
            return $this->errorMessageResponse('Error in submitting in response.');
        }
        return $this->successMessageResponse('Thanks for contacting us. We will get back to you as soon as possible.');
    }
}
