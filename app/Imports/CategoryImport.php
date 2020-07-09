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
        $categories = Category::all()->pluck('name')->toArray();
        if (!in_array($row['name'], $categories)){
            return new Category([
                'name' => $row['name'],
                'slug' => $row['slug']
            ]);
        }
        return;
    }
}
