<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Http\Controllers\ResponserController;
use App\Models\Post;

class PostByCategoryController extends ResponserController
{
    public function postsByCategory($categoryslug)
    {
        $category = Category::where('slug', $categoryslug)->firstOrFail();
        $posts = Post::with('category')->where('category_id', '=', $category->id)->wherePublished(1)->paginate(10);
        return view('front.category.index', [
            'title' => $category->name,
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
