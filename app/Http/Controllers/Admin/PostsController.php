<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Repositories\Admin\Posts\PostsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

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
        $this->postRepository->create($validatedPostData);
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
        // $this->validate($request, Post::rules($id));
        // $post = Post::findOrFail($id);

        // if ($request->hasFile('featured')) {
        //     $featured = $request->featured;
        //     $path = public_path($post->featured);
        //     if (File::exists($path)) {
        //         File::delete($path);
        //     }
        //     $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
        //     $img = Image::make($featured->getRealPath());
        //     $featured_save_path = public_path(Post::POST_FEATURED_PATH);
        //     $img->resize(800, 450)->save($featured_save_path . '/' . $featured_new_name);
        //     // $featured->move(Post::POST_FEATURED_PATH, $featured_new_name);
        //     $post->featured = Post::POST_FEATURED_PATH . $featured_new_name;
        // }

        // $post->admin_id = Auth::guard('admin')->user()->id;
        // $post->title = $request->title;
        // $post->info = $request->info;
        // $post->slug = Str::slug($request->title, '-');
        // $post->content = $request->content;
        // $post->category_id = $request->category_id;
        // $post->meta_title = $request->meta_title;
        // $post->meta_description = $request->meta_description;
        // $post->save();
        // $post->tags()->sync($request->tags);

        // if ($request->hasFile('images')) {
        //     $images = $request->images;
        //     $slug = $post->slug;
        //     $postImages = $post->images;
        //     if ($postImages != null) {
        //         foreach ($postImages as $postImage) {
        //             $postImage->delete();
        //         }
        //     }
        //     $path = public_path(Post::POST_IMAGES_PATH . $slug . '');
        //     if (File::isDirectory($path)) {
        //         File::deleteDirectory($path);
        //     }
        //     File::makeDirectory($path, 0777, true, true);
        //     foreach ($images as $image) {
        //         $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
        //         $image->move(Post::POST_IMAGES_PATH . $slug . '', $image_new_name);
        //         $imageName = Post::POST_IMAGES_PATH . $slug . '/' . $image_new_name;
        //         $PostImages = PostImage::create([
        //             'post_id' => $post->id,
        //             'image' => $imageName
        //         ]);
        //         if (!$PostImages) {
        //             throw new ModelNotFoundException('Error in uploading images.');
        //         }
        //     }
        // }

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
