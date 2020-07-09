<?php

namespace App\Imports;

use App\Tag;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TagsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $tags = Tag::all()->pluck('tag')->toArray();
        if (!in_array($row['tag'], $tags)){
            return new Tag([
                'tag' => $row['tag'],
                'slug' => $row['slug']
            ]);
        }
        return;       
    }
}
