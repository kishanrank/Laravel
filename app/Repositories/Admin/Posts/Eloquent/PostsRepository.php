<?php

namespace App\Repositories\Admin\Posts\Eloquent;

use App\Events\NewPostEvent;
use App\Models\Post;
use App\Models\PostImage;
use App\Repositories\Admin\Posts\PostRepositoryInterface;
use App\Traits\Admin\Post\Attribute\PostAttributeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class PostsRepository implements PostRepositoryInterface
{
    use PostAttributeTrait;

    public $multipleImages = [];
    public $oldDirPath;
    public $data;

    public function all()
    {
        $data = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('admins', 'posts.admin_id', '=', 'admins.id')
            ->whereNull('posts.deleted_at')
            ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published', 'posts.created_at', 'posts.published_at', 'categories.name', 'admins.name as auther')
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return $this->getActionAttributes($data);
            })
            ->addColumn('featured', function ($data) {
                return $this->getFeaturedAttribute($data);
            })
            ->addColumn('status', function ($data) {
                return $this->getPostStatusAttribute($data);
            })
            ->addColumn('upload', function ($data) {
                return $this->getPublishActionAttribute($data);
            })
            ->rawColumns(['action', 'status', 'upload', 'featured'])
            ->make(true);
    }

    public function getAllPublishedPost()
    {
        $data = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.featured', 'posts.title', 'posts.id', 'posts.published_at', 'categories.name')
            ->where('posts.deleted_at', null)
            ->where('posts.published', '=', Post::PUBLISHED)
            ->orderBy('posts.published_at', 'asc')
            ->get();

        return DataTables::of($data)
            ->addColumn('featured', function ($data) {
                return $this->getFeaturedAttribute($data);
            })
            ->addColumn('action', function ($data) {
                return $this->getUnpublishActionAttribute($data);
            })
            ->rawColumns(['featured', 'action'])
            ->make(true);
    }

    public function getAllTrashedPost()
    {
        $data = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.featured', 'posts.title', 'posts.id', 'posts.deleted_at', 'categories.name')
            ->whereNotNull('posts.deleted_at')->get();

        return DataTables::of($data)
            ->addColumn('restore', function ($data) {
                return $this->getRestoreActionAttribute($data);
            })
            ->addColumn('delete', function ($data) {
                return $this->getKillActionAttribute($data);
            })
            ->addColumn('featured', function ($data) {
                return $this->getFeaturedAttribute($data);
            })
            ->rawColumns(['restore', 'delete', 'featured'])
            ->make(true);
    }

    public function kill($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        if (!$post) {
            return false;
        }
        $imagesPath = public_path(Post::POST_IMAGES_PATH . $post->slug);

        if ($imagesPath) {
            File::deleteDirectory($imagesPath);
        }
        Storage::delete($post->featured);

        $post->tags()->detach();
        $result = $post->forceDelete();
        return $result;
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first()->restore();

        return $post;
    }

    public function find($id)
    {
        return Post::find($id);
    }

    public function destroy($id)
    {
        return Post::find($id)->delete(); //returns boolean
    }

    public function store(array $validatedPostData)
    {
        $tagsArray = $this->returnTagsArray($validatedPostData);
        if (isset($validatedPostData['images'])) {
            $this->returnPostImagesArray($validatedPostData);
            unset($validatedPostData['images']);
        }
        unset($validatedPostData['tags']);
        $validatedPostData = $this->storeFeaturedImage($validatedPostData);
        $validatedPostData = $this->postCreatedBy($validatedPostData);
        $validatedPostData = $this->generateSlug($validatedPostData);

        $post = Post::create($validatedPostData);
        $post->tags()->attach($tagsArray);

        if (isset($this->multipleImages) && !empty($this->multipleImages)) {
            $result = $this->storeMultipleImages($post, $this->multipleImages);
        }
        return true;
    }

    public function update($post, $validatedPostData)
    {
        $tagsArray = $this->returnTagsArray($validatedPostData);
        if (isset($validatedPostData['featured'])) {
            $validatedPostData = $this->updateFeaturedImage($post, $validatedPostData);
        }
        if (isset($validatedPostData['images'])) {
            $this->returnPostImagesArray($post, $validatedPostData);
            unset($validatedPostData['images']);
        }
        unset($validatedPostData['tags']);
        $validatedPostData = $this->postCreatedBy($validatedPostData);
        $validatedPostData = $this->generateSlug($validatedPostData);

        $post->update($validatedPostData);
        $post->tags()->sync($tagsArray);

        if (isset($this->multipleImages) && !empty($this->multipleImages)) {
            $this->updateMultipleImages($post, $this->multipleImages, $this->oldDirPath);
        }
        return true;
    }

    public function storeFeaturedImage($validatedPostData)
    {
        $featured = $validatedPostData['featured'];
        $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
        $img = Image::make($featured->getRealPath()); //Image::configure(array('driver' => 'imagick'));
        $featured_save_path = public_path(Post::POST_FEATURED_PATH);
        $img->resize(750, 450)->save($featured_save_path . DIRECTORY_SEPARATOR . $featured_new_name);
        $filename = Post::POST_FEATURED_PATH . $featured_new_name;
        $input = array_merge($validatedPostData, ['featured' => $filename]);
        return $input;
    }

    public function updateFeaturedImage($post, $validatedPostData)
    {
        $featured = $validatedPostData['featured'];
        $path = public_path($post->featured);
        if (File::exists($path)) {
            File::delete($path);
        }
        $featured_new_name = date("Y_m_d_h_i_s") . $featured->getClientOriginalName();
        $img = Image::make($featured->getRealPath());
        $featured_save_path = public_path(Post::POST_FEATURED_PATH);
        $img->resize(750, 450)->save($featured_save_path . DIRECTORY_SEPARATOR . $featured_new_name);
        $filename = Post::POST_FEATURED_PATH . $featured_new_name;
        $input = array_merge($validatedPostData, ['featured' => $filename]);
        return $input;
    }

    public function returnTagsArray(array $validatedPostData)
    {
        return $validatedPostData['tags'];
    }

    public function returnPostImagesArray($post = null, array $validatedPostData)
    {
        $this->multipleImages = $validatedPostData['images'];
        if ($post != null) {
            $this->oldDirPath = public_path(Post::POST_IMAGES_PATH . $post->slug);
        }
        return $this;
    }

    public function postCreatedBy(array $validatedPostData)
    {
        return array_merge($validatedPostData, ['admin_id' => Auth::guard('admin')->user()->id]);
    }

    public function generateSlug(array $validatedPostData)
    {
        return array_merge($validatedPostData, ['slug' => Str::slug($validatedPostData['title'], '-')]);
    }

    public function storeMultipleImages($post, $images)
    {
        $slug = $post->slug;
        $path =  public_path(Post::POST_IMAGES_PATH . $slug . '');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        foreach ($images as $image) {
            $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
            $image->move(Post::POST_IMAGES_PATH . $slug, $image_new_name);
            $imageName = Post::POST_IMAGES_PATH . $slug . DIRECTORY_SEPARATOR . $image_new_name;
            $PostImages = PostImage::create([
                'post_id' => $post->id,
                'image' => $imageName
            ]);
            if (!$PostImages) {
                throw new ModelNotFoundException('Error in uploading images.');
            }
        }
        return true;
    }

    public function updateMultipleImages($post, $images, $oldDirPath)
    {
        $slug = $post->slug;
        $postImages = $post->images;
        if ($postImages != null) {
            foreach ($postImages as $postImage) {
                $postImage->delete();
            }
        }
        $path = public_path(Post::POST_IMAGES_PATH . $slug . '');
        if (File::isDirectory($oldDirPath)) {
            File::deleteDirectory($oldDirPath);
        }
        File::makeDirectory($path, 0777, true, true);
        foreach ($images as $image) {
            $image_new_name = date("Y_m_d_h_i_s") . $image->getClientOriginalName();
            $image->move(Post::POST_IMAGES_PATH . $slug, $image_new_name);
            $imageName = Post::POST_IMAGES_PATH . $slug . DIRECTORY_SEPARATOR . $image_new_name;
            $PostImages = PostImage::create([
                'post_id' => $post->id,
                'image' => $imageName
            ]);
            if (!$PostImages) {
                throw new ModelNotFoundException('Error in uploading images.');
            }
        }
        return true;
    }

    public function publishPost($id)
    {
        $post = Post::find($id);
        $post->published = Post::PUBLISHED;
        $post->published_at = Carbon::now();
        $result = $post->save();
        if ($result) {
            event(new NewPostEvent($post));
        }
        return $result;
    }

    public function unPublishPost($id)
    {
        $post = Post::find($id);
        $post->published = Post::NOT_PUBLISHED;
        $post->published_at = NULL;
        $result = $post->save();
        return $result;
    }
}
