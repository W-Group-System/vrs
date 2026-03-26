<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\VisitorExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $location = Auth::user()->location;
        $start_date = isset($request->start_date) && !empty($request->start_date) ? Carbon::parse($request->start_date)->startOfDay():"";
        $end_date = isset($request->end_date) && !empty($request->end_date) ? Carbon::parse($request->end_date)->endOfDay():"";
        $search = $request->input('search');

        if ($location === null) {
            $visitorTotal = Visitor::query();
        } else {
            $visitorTotal = Visitor::where('building_location', $location);
        }

        $visitors = Visitor::select(
            'id',
            'visitor_id',
            'name',
            'tenant_name',
            'purpose',
            'created_at',
            'updated_at',
            'image',
            'scan_id'
        );

        if (!empty($start_date) && !empty($end_date)) {
            $visitors = $visitors->whereBetween("created_at",[$start_date,$end_date]);
            $visitorTotal = $visitorTotal->whereBetween("created_at",[$start_date,$end_date]);
        }

        if (!empty($search)) {
            $visitors->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('tenant_name', 'LIKE', "%{$search}%")
                ->orWhere('purpose', 'LIKE', "%{$search}%")
                ->orWhere('visitor_id', 'LIKE', "%{$search}%");
            });
        }
        $visitorTotal = $visitorTotal->count();
        $visitors =  $visitors->orderBy("id","desc")
        ->paginate(10)
        ->appends($request->all());
        
        return view('reports.index', compact('visitors', 'visitorTotal'));
    }

    public function dateFilter($start_date, $end_date, $location = null)
    {
        $query = Visitor::whereDate('created_at', '>=', $start_date)
                        ->whereDate('created_at', '<=', $end_date);
        
        if ($location !== null) {
            $query->where('building_location', $location);
        }

        return $query->count();
    }

    public function filter(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();
        $location = Auth::user()->location;

        $visitorTotal = $this->dateFilter($start_date, $end_date, $location);
        
        $visitors = Visitor::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->get();

        return view('reports.index', [
            'visitors' => $visitors,
            'visitorTotal' => $visitorTotal,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function exportCsv(Request $request)
    {
        $start_date = isset($request->start_date) && !empty($request->start_date) ? Carbon::parse($request->start_date)->startOfDay():"";
        $end_date = isset($request->end_date) && !empty($request->end_date) ? Carbon::parse($request->end_date)->endOfDay():"";

        $visitors = Visitor::query();

        if (!empty($start_date) && !empty($end_date)) {
            $visitors->whereBetween("created_at", [$start_date, $end_date]);
        }

        $visitors->orderBy('id', 'desc');

        $filename = "visitors.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($visitors) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Visitor ID',
                'Name',
                'Tenant Name',
                'Purpose',
                'Date Entered'
            ]);

            $visitors->chunk(1000, function ($rows) use ($file) {
                foreach ($rows as $visitor) {
                    fputcsv($file, [
                        $visitor->visitor_id,
                        $visitor->name,
                        $visitor->tenant_name,
                        $visitor->purpose,
                        optional($visitor->created_at)->format('m/d/Y h:i:s A')
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $start_date = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
        $end_date   = $request->filled('end_date')   ? Carbon::parse($request->end_date)->endOfDay()   : null;

        $visitorsQuery = Visitor::query();

        if ($start_date && $end_date) {
            $visitorsQuery->whereBetween('created_at', [$start_date, $end_date]);
        }

        $visitorsQuery->orderBy('id', 'desc');

        // Collect in chunks to avoid memory issues
        $allVisitors = [];
        $visitorsQuery->chunk(1000, function ($rows) use (&$allVisitors) {
            foreach ($rows as $visitor) {
                $allVisitors[] = [
                    'visitor_id'  => $visitor->visitor_id??"",
                    'name'        => $visitor->name??"",
                    'tenant_name' => $visitor->tenant_name??"",
                    'purpose'     => $visitor->purpose??"",
                    'created_at'  => $visitor->created_at
                ];
            }
        });

        // Pass all collected data to PDF
        $pdf = PDF::loadView('pdf.visitors', ['visitors' => $allVisitors]);

        return $pdf->download('visitor_list.pdf');
    }

    public function exportExcel(Request $request)
    {
        $start_date = isset($request->start_date) && !empty($request->start_date) ? Carbon::parse($request->start_date)->startOfDay():"";
        $end_date = isset($request->end_date) && !empty($request->end_date) ? Carbon::parse($request->end_date)->endOfDay():"";
        return Excel::download(new VisitorExport($start_date,$end_date,""), 'visitor_list.xlsx');
    }
}
