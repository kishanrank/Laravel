<?php

namespace App\Http\Controllers\Admin\Post;

use App\Events\NewPostEvent;
use App\Http\Controllers\ResponserController;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PublishedController extends ResponserController
{
    public function published(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published_at', 'categories.name')
                ->where('posts.deleted_at', null)
                ->where('posts.published', '=', Post::PUBLISHED)
                ->orderBy('posts.published_at', 'asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-danger btn-xs"  href="' . route('post.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
                })
                ->rawColumns(['featured', 'action'])
                ->make(true);
        }
        return view('admin.posts.published');
    }

    public function publishPost($id)
    {
        if (Auth::guard('admin')->user()->id != 1) {
            return redirect()->route('posts')->with($this->setNotification('You do not have permission to publish post.', 'error'));
        }

        $post = Post::findOrFail($id);
        if (!$post->id) {
            return redirect(route('posts'))->with($this->setNotification('No data found.', 'error'));
        }

        $post->published = Post::PUBLISHED;
        $post->published_at = Carbon::now();

        if ($post->save()) {
            event(new NewPostEvent($post));
            return redirect()->route('posts')->with($this->setNotification('Post has been successfully published.', 'success'));
        }
    }

    public function unPublishPost($id)
    {
        if (Auth::guard('admin')->user()->id != 1) {
            return redirect()->route('posts')->with($this->setNotification('You do not have permission to un-publish post.', 'error'));
        }

        $post = Post::findOrFail($id);
        if (!$post->id) {
            return redirect(route('posts'))->with($this->setNotification('You do not have permission to un-publish post.', 'error'));
        }

        $post->published = Post::NOT_PUBLISHED;
        $post->published_at = NULL;

        if ($post->save()) {
            return redirect()->route('posts')->with($this->setNotification('Post has been successfully un-published.', 'success'));
        }
    }
}
