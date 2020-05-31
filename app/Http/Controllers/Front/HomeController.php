<?php

namespace App\Http\Controllers\Front;
use App\Category;
use App\Post;
use App\Setting;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        $first_post = Post::orderBy('created_at', 'desc')->first();
        $second_post = Post::orderBy('created_at', 'desc')->skip(1)->take(1)->get()->first();
        return view('front.index', [
            'first_post' => $first_post,
            'second_post' => $second_post,
            'second_category' => Category::orderBy('created_at', 'asc')->skip(1)->take(1)->get()->first(),
            // 'first_line_posts' => Category::orderBy('created_at', 'asc')->first()->posts->take(4),
            // 'second_line_posts' => Category::orderBy('created_at', 'asc')->skip(1)->take(1)->get()->first()->posts->take(4),
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $products = Post::select("title", "slug")
            ->where("title", "LIKE", "%{$query}%")
            ->get();
        $data = [];
        foreach ($products as $product) {
            $url = route('post.single', ['slug' => $product->slug]);
            $link = '<a href="' . "$url" . '">' . " $product->title " . '</a>';
            $data[] = ['title' => $product->title];
            // $data[] = ['title' => $product->title, 'url' => $url];
            // $data['link'][] = $link;
            // $data['url'][] = $url;
        }
        
        if (count($data)) {
            return response()->json($data);
        }
        return ['value' => 'No Result Found', 'slug' => ''];
    }

    public function about() {
        return view('front.about');
    }

    public function contact() {
        return view('front.contact');
    }
    
    public function searchResult(Request $request) {
        $search = $request->get('search');
        if($search == null) {
            return back();
        }
        $posts = Post::select('*')->where('title', 'LIKE', "%{$search}%")->get();
        return view('front.search', compact('posts'));
    }
}
