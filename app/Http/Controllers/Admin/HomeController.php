<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;

class HomeController extends ResponserController
{
    public function index()
    {
        return view('admin.home');
    }
}
