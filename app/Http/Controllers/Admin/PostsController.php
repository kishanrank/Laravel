<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostImage;
use App\Events\NewPostEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->whereNull('posts.deleted_at')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published', 'categories.name')
                ->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-primary btn-xs"  href="' . route('post.edit', $data->id) . '"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-xs"  href="' . route('post.delete', $data->id) . '"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->addColumn('status', function ($data) {
                    if ($data->published) {
                        return '<label class="badge badge-success">Published</label>'; 
                    }
                    return '<label class="badge badge-danger">Not Published</label>';
                })
                ->addColumn('upload', function ($data) {
                    if ($data->published == 0) {
                        return '<a class="btn btn-success btn-sm mr-3"  href="' . route('post.make.published', $data->id) . '"><i class="fas fa-share-square"> Publish</i></a>';
                    }
                    return '<a class="btn btn-danger btn-sm mr-3"  href="' . route('post.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
                })
                ->rawColumns(['action', 'status', 'upload', 'featured'])
                ->make(true);
        }
        return view('admin.posts.index');
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.deleted_at', 'categories.name')
                ->whereNotNull('posts.deleted_at')->get();

            return DataTables::of($data)
                ->addColumn('restore', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('post.restore', $data->id) . '">Restore</a>';
                })
                ->addColumn('delete', function ($data) {
                    return '<a class="btn btn-danger btn-sm mr-3"  href="' . route('post.kill', $data->id) . '">Permanent Delete</a>';
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

    public function published(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.featured', 'posts.title', 'posts.id', 'categories.name')
                ->where('deleted_at', null)
                ->where('published', '=', Post::PUBLISHED)
                ->get();

            return DataTables::of($data)
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->rawColumns(['featured'])
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
            return redirect()->route('posts')->with($this->setNotification('You do not have permission to publish post.', 'error'));
        }

        $post = Post::findOrFail($id);
        if (!$post->id) {
            return redirect(route('posts'))->with($this->setNotification('You do not have permission to publish post.', 'error'));
        }

        $post->published = Post::NOT_PUBLISHED;
        $post->published_at = NULL;

        if ($post->save()) {
            return redirect()->route('posts')->with($this->setNotification('Post has been successfully published.', 'success'));
        }
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('tag', 'ASC')->get();

        if ($categories->count() == 0 || $tags->count() == 0) {
            // View::make('posts.index')->withPosts($posts);
            return redirect()->route('categories.index')->with($this->setNotification('Please add Category and Tags first.', 'error'));
        }
        return view('admin.posts.create', ['categories' => $categories, 'tags' => $tags]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Post::rules(0, ['featured' => 'required']));
        //dimensions:max_width=4096,max_height=4096
        $featured = $request->featured;
        $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
        $featured->move(Post::POST_FEATURED_PATH, $featured_new_name);

        $post = Post::create([
            'admin_id' => Auth::guard('admin')->user()->id,
            'title' => $request->title,
            'info' => $request->info,
            'content' => $request->content,
            'featured' => Post::POST_FEATURED_PATH . $featured_new_name,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title, '-'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description
        ]);

        //         auth()->user()->posts()->create([
        // 'title' => request()->input('title'),
        // 'post_text' => request()->input('post_text'),
        // ]);

        $post->tags()->attach($request->tags);

        if ($request->hasFile('images')) {
            $slug = $post->slug;
            $path =  public_path(Post::POST_IMAGES_PATH . $slug . '');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $images = $request->images;
            foreach ($images as $image) {
                $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
                $image->move(Post::POST_IMAGES_PATH . $slug . '', $image_new_name);
                $imageName = Post::POST_IMAGES_PATH . $slug . '/' . $image_new_name;
                $PostImages = PostImage::create([
                    'post_id' => $post->id,
                    'image' => $imageName
                ]);
                if (!$PostImages) {
                    throw new ModelNotFoundException('Error in uploading images.');
                }
            }
        }
        // event(new NewPostEvent($post));
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

    public function update(Request $request, $id)
    {
        $this->validate($request, Post::rules($id));
        $post = Post::findOrFail($id);

        if ($request->hasFile('featured')) {
            $featured = $request->featured;
            $path = public_path($post->featured);
            if (File::exists($path)) {
                File::delete($path);
            }
            $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
            $featured->move(Post::POST_FEATURED_PATH, $featured_new_name);
            $post->featured = Post::POST_FEATURED_PATH . $featured_new_name;
        }

        $post->admin_id = Auth::guard('admin')->user()->id;
        $post->title = $request->title;
        $post->info = $request->info;
        $post->slug = Str::slug($request->title, '-');
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->save();
        $post->tags()->sync($request->tags);

        if ($request->hasFile('images')) {
            $images = $request->images;
            $slug = $post->slug;
            $postImages = $post->images;
            if ($postImages != null) {
                foreach ($postImages as $postImage) {
                    $postImage->delete();
                }
            }
            $path = public_path(Post::POST_IMAGES_PATH . $slug . '');
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            }
            File::makeDirectory($path, 0777, true, true);
            foreach ($images as $image) {
                $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
                $image->move(Post::POST_IMAGES_PATH . $slug . '', $image_new_name);
                $imageName = Post::POST_IMAGES_PATH . $slug . '/' . $image_new_name;
                $PostImages = PostImage::create([
                    'post_id' => $post->id,
                    'image' => $imageName
                ]);
                if (!$PostImages) {
                    throw new ModelNotFoundException('Error in uploading images.');
                }
            }
        }
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
