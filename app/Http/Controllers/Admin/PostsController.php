<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Repositories\Admin\Posts\Eloquent\PostsRepository;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends ResponserController
{
    protected $postRepository;

    public function __construct(PostsRepository $post)
    {
        $this->postRepository = $post;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('admins', 'posts.admin_id', '=', 'admins.id')
                ->whereNull('posts.deleted_at')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published', 'posts.created_at', 'posts.published_at', 'categories.name', 'admins.name as auther')
                ->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-info btn-xs"  href="' . route('post.show', $data->id) . '"><i class="fa fa-eye"></i></a>&nbsp;<a class="btn btn-primary btn-xs"  href="' . route('post.edit', $data->id) . '"><i class="fa fa-edit"></i></a>&nbsp;<a class="btn btn-danger btn-xs"  href="' . route('post.delete', $data->id) . '"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->addColumn('status', function ($data) {
                    if ($data->published) {
                        return '<label class="badge badge-success">Published</label>';
                    }
                    return '<label class="badge badge-danger">Draft</label>';
                })
                ->addColumn('upload', function ($data) {
                    if ($data->published == 0) {
                        return '<a class="btn btn-success btn-xs"  href="' . route('post.make.published', $data->id) . '"><i class="fas fa-share-square"> Publish</i></a>';
                    }
                    return '<a class="btn btn-danger btn-xs"  href="' . route('post.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
                })
                ->rawColumns(['action', 'status', 'upload', 'featured'])
                ->make(true);
        }
        return view('admin.posts.index');
    }

    public function show(Post $post)
    {
        dd($post);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('tag', 'ASC')->get();

        if ($categories->count() == 0 || $tags->count() == 0) {
            return redirect()->route('categories.index')->with($this->setNotification('Please add Category and Tags first.', 'error'));
        }
        return view('admin.posts.create', ['categories' => $categories, 'tags' => $tags]);
    }

    public function store(StorePostRequest $request)
    {
        $validatedPostData = $request->validated();
        $this->postRepository->store($validatedPostData);
        return redirect()->route('posts')->with($this->setNotification('Post Saved Successfully.', 'success'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect(route('posts'))->with($this->setNotification('Data not found.', 'error'));
        }

        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('tag', 'ASC')->get();

        if ($categories->count() == 0 || $tags->count() == 0) {
            return redirect(route('categories.index'))->with('error', 'Please add Category and Tags first.');
        }

        return view('admin.posts.edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validatedPostData = $request->validated();
        $this->postRepository->update($post, $validatedPostData);

        return redirect()->route('posts')->with($this->setNotification('Post Updated Successfully.', 'success'));
    }

    public function destroy($id) //simple softdelete
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return redirect()->route('posts')->with($this->setNotification('Error in deleting Post.', 'error'));
        }
        if ($post->delete()) {
            return redirect()->route('posts')->with($this->setNotification('Post deleted Successfully.', 'success'));
        }
    }
}
