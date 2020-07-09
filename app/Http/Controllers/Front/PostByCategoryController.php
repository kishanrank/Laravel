<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Http\Controllers\ResponserController;

class PostByCategoryController extends ResponserController
{
    public function postsByCategory($categoryslug)
    {
        $category = Category::where('slug', $categoryslug)->firstOrFail();
        $posts = $category->posts->all();
        return view('front.category.index', [
            'title' => $category->name,
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
