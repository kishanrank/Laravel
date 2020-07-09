<?php

namespace App\Http\Controllers\Front;
use App\Tag;
use App\Http\Controllers\ResponserController;

class PostByTagController extends ResponserController
{
    public function postsByTag($tagslug)
    {
        $tag = Tag::where('slug', $tagslug)->firstOrFail();
        $posts = $tag->posts->all();
        return view('front.tag.index', [
            'title' => $tag->tag,
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }
}
