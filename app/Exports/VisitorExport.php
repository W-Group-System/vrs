<?php

namespace App\Exports;

use App\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitorExport implements FromCollection, WithHeadings
{
    protected $start_date;
    protected $end_date;
    protected $type;

    public function __construct($start_date, $end_date, $type)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->$type = $type;
    }
    public function collection()
    {
        $visitor = Visitor::select('visitor_id', 'name', 'tenant_name', 'purpose', 'created_at');

        if ($this->type=="visitorId") {
            $visitor = $visitor->whereNull('return_id');
        }

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $visitor = $visitor->whereBetween("created_at",[$this->start_date,$this->end_date]);
        }
        
        $visitor = $visitor->get()
        ->map(function ($item) {
            return [
                'visitor_id' => $item->visitor_id,
                'name' => $item->name,
                'tenant_name' => $item->tenant_name,
                'purpose' => $item->purpose,
                'created_at' => optional($item->created_at)->format('m/d/Y h:i A'),
            ];
        });

        return $visitor;
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
