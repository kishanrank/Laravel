<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResponserController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;

class HomeController extends ResponserController
{
    public $data = [];
    
    public function index()
    {
        $this->data['category'] = Category::all()->count();
        $this->data['tag'] = Tag::all()->count();
        $this->data['published_posts'] = Post::wherePublished(1)->whereNull('deleted_at')->count();
        $this->data['subscribers'] = Subscriber::all()->count();
        return view('admin.home', ['data' => $this->data]);
    }
}
