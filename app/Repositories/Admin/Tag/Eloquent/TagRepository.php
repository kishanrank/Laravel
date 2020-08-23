<?php

namespace App\Repositories\Admin\Tag\Eloquent;

use App\Models\Tag;
use Illuminate\Support\Str;
use App\Repositories\Admin\Tag\TagRepositoryInterface;
use App\Traits\Admin\Tag\Attribute\TagAttributeTrait;
use Yajra\DataTables\Facades\DataTables;

class TagRepository implements TagRepositoryInterface
{
    use TagAttributeTrait;
    public function all()
    {
        $data = Tag::latest()->get(['id', 'tag', 'slug']);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return $this->getActionAttributes($data);
            })
            ->addColumn('checkbox', $this->getCheckBoxAttribute())
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function store(array $validatedTagData)
    {

        $tag_data = [
            'tag' => $validatedTagData['tag'],
            'slug' => Str::slug($validatedTagData['tag'], '-'),
            'description' => $validatedTagData['description']
        ];

        $tag = Tag::create($tag_data);

        return $tag;
    }

    public function find($id)
    {
        return Tag::findOrFail($id)->only('id', 'tag', 'description');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        $result = $tag->delete();

        return $result;
    }

    public function update($tag, array $validatedTagData)
    {
        $tag_data = [
            'tag'    =>  $validatedTagData['tag'],
            'slug'     =>  Str::slug($validatedTagData['tag'], '-'),
            'description' => $validatedTagData['description']
        ];

        $tag = $tag->update($tag_data);

        return $tag;
    }

    public function massDelete(array $tagIds)
    {
        $tags = Tag::whereIn('id', $tagIds);

        $result = $tags->delete();

        return $result;
    }
}
