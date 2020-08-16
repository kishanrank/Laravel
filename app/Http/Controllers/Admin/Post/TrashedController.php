<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\ResponserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TrashedController extends ResponserController
{
    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.deleted_at', 'categories.name')
                ->whereNotNull('posts.deleted_at')->get();

            return DataTables::of($data)
                ->addColumn('restore', function ($data) {
                    return '<a class="btn btn-primary btn-xs"  href="' . route('post.restore', $data->id) . '">Restore</a>';
                })
                ->addColumn('delete', function ($data) {
                    return '<a class="btn btn-danger btn-xs"  href="' . route('post.kill', $data->id) . '">Permanent Delete</a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->rawColumns(['restore', 'delete', 'featured'])
                ->make(true);
        }
        return view('admin.posts.trashed');
    }

    public function kill($id) //forcedelete
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        if (!$post) {
            return redirect()->back()->with($this->setNotification('Error in deleting Post.', 'error'));
        }

        $imagesPath = public_path(Post::POST_IMAGES_PATH . $post->slug);

        if ($imagesPath) {
            File::deleteDirectory($imagesPath);
        }

        Storage::delete($post->featured);

        $post->tags()->detach();
        $post->forceDelete();

        return redirect()->back()->with($this->setNotification('Post deleted permanently.', 'success'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first()->restore();

        if ($post == null) {
            return back()->with($this->setNotification('Error in restoring Post.', 'error'));
        }
        return redirect()->back()->with($this->setNotification('Post Restored successfully.', 'success'));
    }
}
