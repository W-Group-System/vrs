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
    protected $status;
    protected $tenant;

    public function __construct($start_date, $end_date, $type, $status, $tenant)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->type = $type;
        $this->status = $status;
        $this->tenant = $tenant;
    }
    public function collection()
    {
        $visitor = Visitor::with(['building'])->select('visitor_id', 'name', 'tenant_name', 'purpose', 'created_at','updated_at','building_location');
        $status = $this->status;
        if ($this->type=="visitorId") {
            if ($this->status == "returned") {
                $visitor = $visitor->where('return_id',1);
            }else{
                $visitor = $visitor->whereNull('return_id');
            }
        }

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $visitor = $visitor->whereBetween("created_at",[$this->start_date,$this->end_date]);
        }
        if (!empty($this->tenant)) {
            $visitor = $visitor->where("tenant_name",$this->tenant);
        }
        
        $visitor = $visitor->get()
        ->map(function ($item) use($status){
            if ($status == "returned") {
                return [
                    'name' => $item->name,
                    'building' => $item->building->name,
                    'tenant_name' => $item->tenant_name,
                    'purpose' => $item->purpose,
                    'created_at' => optional($item->created_at)->format('m/d/Y h:i A'),
                    'updated_at' => optional($item->updated_at)->format('m/d/Y h:i A'),
                ];
            }else{
                return [
                    'visitor_id' => $item->visitor_id,
                    'name' => $item->name,
                    'tenant_name' => $item->tenant_name,
                    'purpose' => $item->purpose,
                    'created_at' => optional($item->created_at)->format('m/d/Y h:i A'),
                ];
            }
        });

        return $visitor;
    }

    public function headings(): array
    {
        if ($this->status == "returned") {
            return [
                'Name',
                'Building Name',
                'Tenant Name',
                'Purpose',
                'Date Entered',
                'Date Exit'
            ];
        }else{
            return [
                'Visitor ID',
                'Name',
                'Tenant',
                'Purpose',
                'Date Entered'
            ];
        }
    }
}
