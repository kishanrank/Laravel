<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Http\Controllers\Controller;

class PostByCategoryController extends Controller
{
    public function postsByCategory($categoryslug)
    {
        $category = Category::where('slug', $categoryslug)->firstOrFail();
        $posts = $category->posts->all();
        return view('front.category', [
            'title' => $category->name,
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
