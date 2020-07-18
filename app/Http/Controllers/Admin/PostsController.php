<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\PostImage;
use App\Events\NewPostEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published', 'categories.name')
                ->where('deleted_at', null)
                ->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('post.edit', $data->id) . '"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-sm mr-3"  href="' . route('post.delete', $data->id) . '"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->addColumn('upload', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('post.edit', $data->id) . '"><i class="fa fa-upload">Publish</i></a>';
                })
                ->rawColumns(['action', 'upload', 'featured'])
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

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        if ($categories->count() == 0 || $tags->count() == 0) {
            $notification = array(
            'message' => 'Please add Category and Tags first.',
            'alert-type' => 'error'
        );
        // View::make('posts.index')->withPosts($posts);
        return redirect()->route('categories.index')->with($notification);
        }
        return view('admin.posts.create', ['categories' => $categories, 'tags' => $tags]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Post::rules(0, ['featured' => 'required'])); 
        //dimensions:max_width=4096,max_height=4096
        $featured = $request->featured;
        $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
        $featured->move('uploads/posts/featured', $featured_new_name);

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'info' => $request->info,
            'content' => $request->content,
            'featured' => 'uploads/posts/featured/' . $featured_new_name,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title, '-'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description
        ]);

        $post->tags()->attach($request->tags);

        if ($request->hasFile('images')) {
            $slug = $post->slug;
            $path =  public_path('uploads/posts/images/' . $slug . '');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $images = $request->images;
            foreach ($images as $image) {
                $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
                $image->move('uploads/posts/images/' . $slug . '', $image_new_name);
                $imageName = 'uploads/posts/images/' . $slug . '/' . $image_new_name;
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

        $notification = array(
            'message' => 'Post Saved Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('posts')->with($notification);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect(route('posts'))->with('error', 'Data not found.');
        }
        $categories = Category::all();
        $tags = Tag::all();
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
            $featured->move('uploads/posts/featured', $featured_new_name);
            $post->featured = 'uploads/posts/featured/' . $featured_new_name;
        }

        $post->user_id = Auth::user()->id;
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
            $path = public_path('uploads/posts/images/' . $slug . '');
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            }
            File::makeDirectory($path, 0777, true, true);
            foreach ($images as $image) {
                $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
                $image->move('uploads/posts/images/' . $slug . '', $image_new_name);
                $imageName = 'uploads/posts/images/' . $slug . '/' . $image_new_name;
                $PostImages = PostImage::create([
                    'post_id' => $post->id,
                    'image' => $imageName
                ]);
                if (!$PostImages) {
                    throw new ModelNotFoundException('Error in uploading images.');
                }
            }
        }
        $notification = array(
            'message' => 'Post updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('posts')->with($notification);
    }

    public function publishPost($id) {

    }

    public function unPublishPost($id) {

    }

    
    public function destroy($id) //simple softdelete
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            $notification = array(
                'message' => 'Error in deleting Post.',
                'alert-type' => 'error'
            );
            return redirect()->route('posts')->with($notification);
        }
        if ($post->delete()) {
            $notification = array(
                'message' => 'Post deleted successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('posts')->with($notification);
        }
    }

    public function kill($id) //forcedelete
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        if (!$post) {
            $notification = array(
                'message' => 'Error in deleting Post.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $imagesPath = public_path('uploads/posts/images/' . $post->slug . '');

        if ($imagesPath) {
            File::deleteDirectory($imagesPath);
        }
        File::delete($post->featured);

        $post->tags()->detach();
        $post->forceDelete();

        $notification = array(
            'message' => 'Post deleted permanently.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first()->restore();
        if ($post == null) {
            $notification = array(
                'message' => 'Error in restoring Post.',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        $notification = array(
            'message' => 'Post Restored successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
