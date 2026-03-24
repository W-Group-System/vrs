<?php

namespace App\Http\Controllers;
use App\Visitor;
use App\Tenant;
use App\Building;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
    public function visitor_id() 
    {
        $visitors = Visitor::where('return_id', null)->orderBy('id', 'desc')->get();
        $buildings = Building::all();
        return view('visitors.visitor_id', compact('visitors', 'buildings')); 
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
}
