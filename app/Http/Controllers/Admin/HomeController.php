<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\ResponserController;

class HomeController extends ResponserController
{
    public function index()
    {
        return view('admin.home');
    }
}
