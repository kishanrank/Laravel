<?php

namespace App\Http\Controllers\Front;
use App\Post;
use App\Http\Controllers\ResponserController;

class SinglePostController extends ResponserController
{
    public function single($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $next_id = Post::where('id', '>', $post->id)->min('id');
        $prev_id = Post::where('id', '<', $post->id)->max('id');
        $next_post = Post::find($next_id);
        $previous_post = Post::find($prev_id);
        return view('front.single.index', [
            'title' => $post->title,
            'post' => $post,
            'next_post' => $next_post,
            'previous_post' => $previous_post,
        ]);
    }
}
