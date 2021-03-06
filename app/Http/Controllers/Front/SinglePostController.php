<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use App\Http\Controllers\ResponserController;
use Illuminate\Support\Facades\DB;

class SinglePostController extends ResponserController
{
    public function single($slug)
    {
        $post = Post::where('slug', $slug)->wherePublished(1)->firstOrFail();
        $previous_post = Post::select('slug')->where('id', '<', $post->id)->orderBy('id','desc')->wherePublished(1)->first();
        $next_post = Post::select('slug')->where('id', '>', $post->id)->orderBy('id')->wherePublished(1)->first();
        // $next_id = Post::where('id', '>', $post->id)->wherePublished(1)->min('id');
        // $prev_id = Post::where('id', '<', $post->id)->wherePublished(1)->max('id');
        // $next_post = Post::find($next_id);
        // $previous_post = Post::find($prev_id);
        return view('front.single.index', [
            'title' => $post->title,
            'post' => $post,
            'next_post' => $next_post,
            'previous_post' => $previous_post,
        ]);
    }
}
