<?php

namespace App\Http\Controllers\Front;
use App\Tag;
use App\Http\Controllers\ResponserController;

class PostByTagController extends ResponserController
{
    public function postsByTag($tagslug)
    {
        $tag = Tag::where('slug', $tagslug)->firstOrFail();
        $posts = $tag->posts()->paginate(10);
        // $tag->setRelation('posts', $tag->posts()->paginate(10));
        return view('front.tag.index', [
            'title' => $tag->tag,
            'tag' => $tag,
            'posts' => $posts
        ]);
    }
}
