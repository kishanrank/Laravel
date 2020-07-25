<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public $start;
    public $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::select("users.*")
        ->whereBetween('created_at', [$this->start, $this->end])
        ->get();
        return $users;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Email',
            'Admin',
            'Active',
            'Email Verified At',
            'Created_at',
            'Updated_at'
        ];
    }
}
