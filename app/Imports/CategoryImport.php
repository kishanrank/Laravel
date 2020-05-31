<?php

namespace App\Imports;

use App\Category;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $header = ['name', 'slug'];
        // $cnt = true;
        // foreach ($row as $key => $value) {
        //     if (!array_key_exists($key, $header)) {
        //         $cnt = false;
        //     }
        //     if($cnt == false) {
        //         throw new Exception("Headers not matching.");
        //     }
        // }
        $category =  new Category([
            'name' => $row['name'],
            'slug' => $row['slug']
        ]);
        if (!$category) {
            return false;
        }
        return $category;
    }
}
