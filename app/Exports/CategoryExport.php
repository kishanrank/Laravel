<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Category::all();
        return DB::table('categories')
            ->select('categories.*', DB::raw('DATE_FORMAT(categories.created_at, "%d-%b-%Y") as created_at'))->get();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Slug',
            'Description',
            'Meta Title',
            'Meta Description',
            'created_at',
            'updated_at'
        ];
    }
}
