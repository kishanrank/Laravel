<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Post;

class SinglePostController extends Controller
{
    public function single($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $next_id = Post::where('id', '>', $post->id)->min('id');
        $prev_id = Post::where('id', '<', $post->id)->max('id');
        $next_post = Post::findOrFail($next_id);
        $previous_post = Post::findOrFail($prev_id);
        return view('front.single', [
            'title' => $post->title,
            'post' => $post,
            'next_post' => $next_post,
            'previous_post' => $previous_post,
        ]);
    }
}
