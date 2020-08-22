<?php

namespace App\Http\Controllers\Admin\Post;

use App\Events\NewPostEvent;
use App\Http\Controllers\ResponserController;
use App\Models\Post;
use App\Repositories\Admin\Posts\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PublishedController extends ResponserController
{
    public $postRepository;

    public function __construct(PostRepositoryInterface $post)
    {
        $this->postRepository = $post;
    }

    public function published(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->postRepository->getAllPublishedPost();
            }
            return view('admin.posts.published');
        } catch (\Throwable $e) {
            return redirect(route('admin.hme'))->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function publishPost($id)
    {
        try {
            if (Auth::guard('admin')->user()->id != 1) {
                return redirect()->route('posts')->with($this->setNotification('You do not have permission to publish post.', 'error'));
            }
            $this->postRepository->publishPost($id);

            return redirect()->route('posts')->with($this->setNotification('Post has been successfully published.', 'success'));
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function unPublishPost($id)
    {
        try {
            if (Auth::guard('admin')->user()->id != 1) {
                return redirect()->route('posts')->with($this->setNotification('You do not have permission to un-publish post.', 'error'));
            }
            $this->postRepository->unPublishPost($id);

            return redirect()->route('posts')->with($this->setNotification('Post has been successfully un-published.', 'success'));
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }
}
