<?php

namespace App\Repositories\Admin\Posts\Eloquent;

use App\Models\Post;
use App\Models\PostImage;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostsRepository extends BaseRepository
{
    public $multipleImages = [];
    public $oldDirPath;

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
        $img = Image::make($featured->getRealPath());
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
}
