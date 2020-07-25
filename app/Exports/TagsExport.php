<?php

namespace App\Exports;

use App\Models\Tag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TagsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tag::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Tag',
            'Slug',
            'created_at',
            'updated_at'
        ];
    }
}
