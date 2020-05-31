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
        // $header = ['tag', 'slug'];
        // $cnt = true;
        // foreach ($row as $key => $value) {
        //     if (!array_key_exists($key, $header)) {
        //         $cnt = false;
        //     }
        //     if ($cnt == false) {
        //         throw new Exception("Headers not matching.");
        //     }
        // }
        return new Tag([
            'tag' => $row['tag'],
            'slug' => $row['slug']
        ]);
    }
}
