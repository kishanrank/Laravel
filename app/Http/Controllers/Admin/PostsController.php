<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Repositories\Admin\Posts\PostRepositoryInterface;
use Throwable;

class PostsController extends ResponserController
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $post)
    {
        $this->postRepository = $post;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->postRepository->all();
            }
            return view('admin.posts.index');
        } catch (Throwable $e) {
            return redirect(route('admin.home'))->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function show(Post $post)
    {
        dd($post);
    }

    public function create()
    {
        try {
            $categories = Category::orderBy('name', 'ASC')->get();
            $tags = Tag::orderBy('tag', 'ASC')->get();

            if ($categories->count() == 0 || $tags->count() == 0) {
                return redirect()->route('categories.index')->with($this->setNotification('Please add Category and Tags first.', 'error'));
            }
            return view('admin.posts.create', compact('categories', 'tags'));
        } catch (Throwable $e) {
            return redirect(route('posts'))->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            $validatedPostData = $request->validated();
            $result = $this->postRepository->store($validatedPostData);

            if ($result) {
                return redirect()->route('posts')->with($this->setNotification('Post Saved Successfully.', 'success'));
            }
        } catch (Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function edit($id)
    {
        try {
            $post = $this->postRepository->find($id);
            if (!$post) {
                return redirect(route('posts'))->with($this->setNotification('Data not found.', 'error'));
            }

            $categories = Category::orderBy('name', 'ASC')->get();
            $tags = Tag::orderBy('tag', 'ASC')->get();

            if ($categories->count() == 0 || $tags->count() == 0) {
                return redirect(route('categories.index'))->with('error', 'Please add Category and Tags first.');
            }

            return view('admin.posts.edit', compact('post', 'categories', 'tags'));
        } catch (Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $validatedPostData = $request->validated();
            $result = $this->postRepository->update($post, $validatedPostData);

            if ($result) {
                return redirect()->route('posts')->with($this->setNotification('Post Updated Successfully.', 'success'));
            }
        } catch (Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function destroy($id) //simple softdelete
    {
        try {
            $this->postRepository->destroy($id);

            return redirect()->route('posts')->with($this->setNotification('Post deleted Successfully.', 'success'));
        } catch (Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }
}
