<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\ResponserController;
use App\Repositories\Admin\Posts\PostRepositoryInterface;
use Illuminate\Http\Request;

class TrashedController extends ResponserController
{
    public $postRepository;

    public function __construct(PostRepositoryInterface $post)
    {
        $this->postRepository = $post;
    }

    public function trashed(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->postRepository->getAllTrashedPost();
            }
            return view('admin.posts.trashed');
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function kill($id) //forcedelete
    {
        try {
            $result = $this->postRepository->kill($id);

            if ($result) {
                return redirect()->back()->with($this->setNotification('Post deleted permanently.', 'success'));
            }
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function restore($id)
    {
        try {
            $this->postRepository->restore($id);
            return back()->with($this->setNotification('Post Restored successfully.', 'success'));
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }
}
