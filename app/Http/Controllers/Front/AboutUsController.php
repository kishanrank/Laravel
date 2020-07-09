<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\ResponserController;
use Illuminate\Http\Request;

class AboutUsController extends ResponserController
{
	public function index() {
    	return view('front.aboutus.index');
	}
}
