<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Post;

class PostByCategoryController extends Controller
{
    public function postsByCategory($categoryslug)
    {
        $category = Post::where('slug', $categoryslug)->firstOrFail();
        $posts = $category->posts->all();
        return view('front.category', [
            'title' => $category->name,
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
