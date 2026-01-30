<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $location = Auth::user()->location;

        if ($location === null) {
            $visitorTotal = Visitor::count();
        } else {
            $visitorTotal = Visitor::where('building_location', $location)->count();
        }

        $visitors = Visitor::select(
            'visitor_id',
            'image',
            'name',
            'tenant_name',
            'purpose',
            'created_at',
            'updated_at'
        )->get();
        
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
}
