<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrationsExport implements FromCollection, WithHeadings
{
    protected int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        return Registration::where('event_id', $this->eventId)
            ->select(
                'name',
                'email',
                'phone',
                'organization',
                'position',
                'gender',
                'age',
                'vulnerable'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Organization',
            'Position',
            'Gender',
            'Age',
            'Vulnerable'
        ];
    }
}