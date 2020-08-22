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
        return DB::table('categories')
            ->select('id', 'name', 'slug', 'description', 'meta_title', 'meta_description', 'created_at', 'updated_at')
            ->orderBy('id', 'asc')
            ->get();
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
            'Created At',
            'Updated At'
        ];
    }
}
