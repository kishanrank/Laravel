<?php

namespace App\Exports;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TagsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('tags')
            ->select('id', 'tag', 'slug', 'description', 'meta_title', 'meta_description', 'created_at', 'updated_at')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Tag',
            'Slug',
            'Description',
            'Meta Title',
            'Meta Description',
            'Create At',
            'Updated At'
        ];
    }
}
