<?php

namespace App\Repositories\Admin\Category\Eloquent;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Traits\Admin\Category\Attribute\CategoryAttributeTrait;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository implements CategoryRepositoryInterface
{
    use CategoryAttributeTrait;

    public function all()
    {
        $data = Category::latest()->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return $this->getActionAttributes($data);
            })
            ->addColumn('checkbox', $this->getCheckBoxAttribute())
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function store(array $categoryData)
    {
        $category_data = [
            'name' => $categoryData['name'],
            'slug' => Str::slug($categoryData['name'], '-'),
            'description' => $categoryData['description']
        ];
        $category = Category::create($category_data);
        if ($category) {
            return true;
        }
        return false;
    }

    public function find($id)
    {
        return Category::findOrFail($id)->only('id', 'name', 'description');
    }

    public function update($category, array $categoryData)
    {
        $category_data = [
            'name'    =>  $categoryData['name'],
            'slug'     =>  Str::slug($categoryData['name'], '-'),
            'description' => $categoryData['description'],
        ];
        $category = $category->update($category_data);

        if ($category) {
            return true;
        }
        return false;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $posts = $category->posts;
        $result = $category->delete();
        foreach ($posts as $post) {
            $post->delete();
        }
        return $result;
    }

    public function massDelete(array $categoryIds)
    {
        $categories = Category::whereIn('id', $categoryIds);
        $posts = Post::whereIn('category_id', $categoryIds);
        if ($categories->delete()) {
            $posts->delete();
        }
        return true;
    }
}
