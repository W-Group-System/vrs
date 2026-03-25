<?php

namespace App\Exports;

use App\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Visitor::whereNull('return_id')
            ->select('visitor_id', 'name', 'tenant_name', 'purpose', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'visitor_id' => $item->visitor_id,
                    'name' => $item->name,
                    'tenant_name' => $item->tenant_name,
                    'purpose' => $item->purpose,
                    'created_at' => optional($item->created_at)->format('m/d/Y h:i A'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Visitor ID',
            'Name',
            'Tenant',
            'Purpose',
            'Date Entered'
        ];
    }
}
