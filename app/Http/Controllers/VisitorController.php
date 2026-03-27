<?php

namespace App\Http\Controllers;
use App\Visitor;
use App\Tenant;
use App\Building;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\VisitorExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class VisitorController extends Controller
{
    // Home
    public function index($id) 
    {
        $building = Building::findOrfail($id);
        // $visitors = Visitor::all();
        // $tenants = Tenant::pluck('name')->toArray();
        $tenants = Tenant::where('building_id', $building->id)->pluck('name')->toArray();
        return view('visitors.index', compact('tenants', 'building')); 
    }

    // Store
    public function store(Request $request, $building_id)
    {
        $new_visitor = new Visitor;
        $new_visitor->scan_id = $request->scan_id;
        $new_visitor->image = $request->image;
        $new_visitor->name = $request->name;
        $new_visitor->tenant_name = $request->tenant_name;
        $new_visitor->purpose = $request->purpose;
        $new_visitor->building_location = $building_id;
        $new_visitor->save();
        Alert::success('Thank you for visiting us today!', 'We hope you had a wonderful time exploring our building. Have a fantastic day ahead!');
        return back();
    }

    // Visitor ID List
    public function visitor_id(Request $request) 
    {
        $search = $request->input('search');

        $visitors = Visitor::select(
            "id",
            "image",
            "scan_id",
            "name",
            "tenant_name",
            "visitor_id",
            "return_id",
            "purpose",
            "building_location",
            "created_at"
        )
        ->whereNull('return_id');
        
        if (auth()->user()->name !== 'Admin') {
            $visitors = $visitors->where("building_location",auth()->user()->location);
        }

        if (!empty($search)) {
            $visitors->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('tenant_name', 'LIKE', "%{$search}%")
                ->orWhere('purpose', 'LIKE', "%{$search}%")
                ->orWhere('visitor_id', 'LIKE', "%{$search}%");
            });
        }

        $visitors = $visitors
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->all());
        $buildings = Building::all();
        return view('visitors.visitor_id', compact('visitors', 'buildings'));
    }

    public function VisitorIdV2(Request $request) 
    {
        
        return view('visitors.visitorIdV2');
    }

    public function VisitorList(Request $request){
        $response = [
            "isSuccess"=>false,
            "message"=>"Failed to retrieve information.",
            "total"=>0,
            "page"=>1,
            "data"=>null
        ];
        $isSuccess = false;
        try {
            $page = $request->page ?? 1;
            $limit = $request->limit ?? 10;

            $visitorList = Visitor::with(['building'])->select(
                "id",
                "name",
                "tenant_name",
                "visitor_id",
                "return_id",
                "purpose",
                "building_location",
                // "created_at"
                DB::raw("DATE_FORMAT(created_at, '%m/%d/%Y %h:%i:%s %p') AS 'formatted_created_at'")
            )
            ->whereNull('return_id');

            if (isset($request->id) && !empty($request->id)) {
                $visitorList->addSelect("image","scan_id");
                $visitorList = $visitorList->where("id",$request->id);
            }

            if (isset($request->search) && !empty(isset($request->search))) {
                $search = $request->search;
                $visitorList = $visitorList->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('tenant_name', 'LIKE', "%{$search}%")
                        ->orWhere('purpose', 'LIKE', "%{$search}%")
                        ->orWhere('visitor_id', 'LIKE', "%{$search}%");
                });
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end   = Carbon::parse($request->end_date)->endOfDay();

                $visitorList->whereBetween('created_at', [$start, $end]);
            }

            $totalCount = (clone $visitorList)->count();

            $visitorList = $visitorList->orderBy("id","desc") 
                ->skip(($page - 1) * $limit)
                ->take($limit)
                ->get();
            $isSuccess = true;
            $response["isSuccess"] = $isSuccess;
            $response["message"] = "Successfully retrieved information.";
            $response["total"] = $totalCount;
            $response["data"] = $visitorList;
        } catch (\Throwable $th) {
            Log::error("ERROR IN GETTING VISITORS LIST: ".$th);
        }

        if ($isSuccess) {
            return response()->json($response,200);
        }else{
            return response()->json($response,400);
        }
        
        return $response;
    }

    // Add Visitor ID
    public function new_id(Request $request, $id) {
        $new_id = Visitor::find($id);
        $new_id->visitor_id = $request->input('visitor_id');
        $new_id->save();
        Alert::success('Success Title', 'Success Message');
        return back();
    }

    // Return ID
    public function return_id($id) { 
        $data = Visitor::find($id);
        if ($data) {
            $data->return_id = 1; 
            $data->save();
        }
        Alert::success('Success Title', 'Success Message');
        return back();
    }

    public function ReturnId(Request $request) { 
        $response = ["message"=>"Failed to process returning of ID."];
        $isSuccess = false;
        try {
            $id = $request->id??"";
            $data = Visitor::find($id);
            if ($data) {
                $data->return_id = 1; 
                $data->save();
                $isSuccess = true;
                $response = ["message"=>"ID Returned succesfully."];
            }
        } catch (\Throwable $th) {
            Log::error("ERROR IN RETURN PROCESS ID: {$th->getMessage()}");
        }
        
        if ($isSuccess) {
            return response()->json($response,200);
        }else{
            return response()->json($response,400);
        }
    }

    public function exportCsv(Request $request)
    {
        $filename = "visitors.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $query = Visitor::query()->whereNull('return_id');
        $visitors = $query->orderBy('id', 'desc')->get();

        $columns = ['Visitor ID', 'Name', 'Tenant Name', 'Purpose', 'Date Entered'];

        $callback = function() use ($visitors, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($visitors as $visitor) {
                fputcsv($file, [
                    $visitor->visitor_id,
                    $visitor->name,
                    $visitor->tenant_name,
                    $visitor->purpose,
                    optional($visitor->created_at)->format('m/d/Y h:i:s A')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function CreateId(Request $request) {
        $response = [
            "message"=>"Failed to create new id"
        ];
        $isSuccess = false;
        try {
            $id = $request->id??"";
            $createdId = $request->visitor_id??"";
            if (!empty($id) && !empty($createdId)) {
                $updateVisitorData = Visitor::where('id', $id)->update(['visitor_id' => $createdId]);
                $response = ["message"=>"New id created."];
                $isSuccess = true;
            }else{
                $response = ["message"=>"Invalid id"];
            }
            
        } catch (\Throwable $th) {
            Log::error("ERROR IN CREATING NEW ID: {$th->getMessage()}");
            dd($th->getMessage());
        }
        
        if ($isSuccess) {
            return response()->json($response,200);
        }else{
            return response()->json($response,400);
        }
    }

    public function exportPdf(Request $request)
    {
        $visitors = Visitor::whereNull('return_id')->orderBy('id', 'desc')->get();
        $pdf = PDF::loadView('pdf.visitors', compact('visitors'));

        return $pdf->download('visitor_list.pdf'); // download
        // return $pdf->stream('visitor_list.pdf'); // preview in browser
    }

    public function exportExcel(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();
        return Excel::download(new VisitorExport($start_date,$end_date,"visitorId"), 'visitor_list.xlsx');
    }

    public function ShowImage($type,$id)
    {
        
        $record = Visitor::findOrFail($id);
        $base64 = "";
        
        switch ($type) {
            case 'scan_id':
                $base64 = $record->scan_id;
                break;
            case 'image':
                $base64 = $record->image;
                break;
            default:
                $base64 = "";
                break;
        }

        preg_match('/^data:image\/(\w+);base64,/', $base64, $type);

        $base64 = substr($base64, strpos($base64, ',') + 1);
        $base64 = base64_decode($base64);

        $imageType = $type[1] ?? 'jpeg';

        return response($base64)
            ->header('Content-Type', 'image/' . $imageType);
    }
}
