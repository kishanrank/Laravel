<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Tag;

class PostByTagController extends Controller
{
    public function postsByTag($tagslug)
    {
        $tag = Tag::where('slug', $tagslug)->firstOrFail();
        $posts = $tag->posts->all();
        return view('front.tag', [
            'title' => $tag->tag,
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }

}
