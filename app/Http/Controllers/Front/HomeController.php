<?php

namespace App\Http\Controllers\Front;

use App\Post;
use App\News;
use App\Http\Controllers\ResponserController;
use Illuminate\Http\Request;

class HomeController extends ResponserController
{
    public function index()
    {
        $first_post = Post::whereNull('deleted_at')->wherePublished(1)->orderBy('created_at', 'desc')->get()->first();
        $second_post = Post::whereNull('deleted_at')->wherePublished(1)->orderBy('created_at', 'desc')->skip(1)->take(1)->get()->first();
        $news_post = News::orderBy('created_at', 'desc')->paginate(4);
        $first_line_recent_posts = Post::whereNull('deleted_at')->wherePublished(1)->orderBy('created_at  ', 'desc')->skip(2)->take(3)->get();
        $second_line_recent_post = Post::whereNull('deleted_at')->wherePublished(1)->orderBy('created_at', 'desc')->skip(5)->take(3)->get();
        return view('front.index', [
            'first_post' => $first_post,
            'second_post' => $second_post,
            'news_post' => $news_post,
            'first_line_recent_posts' => $first_line_recent_posts,
            'second_line_recent_posts' => $second_line_recent_post
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $posts = Post::select("title", "slug")
            ->where("title", "LIKE", "%{$query}%")->wherePublished(1)
            ->get();
        $data = [];
        foreach ($posts as $post) {
            $url = route('post.single', ['slug' => $post->slug]);
            $link = '<a href="' . "$url" . '">' . " $post->title " . '</a>';
            $data[] = ['title' => $post->title, 'url' => $url];
            // $data[] = ['title' => $product->title, 'url' => $url];
            // $data['link'][] = $link;
            // $data['url'][] = $url;
        }

        if (count($data)) {
            return response()->json($data);
        }
        return ['value' => 'No Result Found', 'slug' => ''];
    }

    public function searchResult(Request $request)
    {
        $search = $request->get('search');
        if ($search == null) {
            return back();
        }
        $posts = Post::select('*')->where('title', 'LIKE', "%{$search}%")->wherePublished(1)->paginate(10);
        return view('front.search.index', compact('posts'));
    }
}
