<?php

namespace App\Exports;

use App\Subscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriberExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Subscriber::all();
    }

    public function headings(): array
    {
        return  ['Id', 'Email', 'Created_at', 'Updated_at'];
    }
}
