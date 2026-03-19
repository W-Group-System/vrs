@extends('layouts.header')
@section('content')
@if(auth()->user()->location || auth()->user()->role == 'Admin')
<div class="wrapper wrapper-content animated fadeInLeft" style="padding: 20px 10px 0px">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-success">Visitors</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $visitorTotal = \App\Visitor::count();
                        } else {
                            $visitorTotal = \App\Visitor::where('building_location', auth()->user()->location)->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $visitorTotal }}</h1>
                    <div class="stat-percent font-bold text-success"><i class="fa fa-users"></i></div>
                    <small>Total Visitor</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-info">Business Visits</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $businessTotal = \App\Visitor::where('purpose', 'Business Visits')->count();
                        } else {
                            $businessTotal = \App\Visitor::where('purpose', 'Business Visits')
                                        ->where('building_location', auth()->user()->location)
                                        ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $businessTotal }}</h1>
                    <div class="stat-percent font-bold text-info"><i class="fa fa-briefcase"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-navy">Personal visits</h5>
                </div>
                <div class="ibox-content"> 
                    @php
                        if (auth()->user()->location === null) {
                            $personalTotal = \App\Visitor::where('purpose', 'Personal Visits')->count();
                        } else {
                            $personalTotal = \App\Visitor::where('purpose', 'Personal Visits')
                                            ->where('building_location', auth()->user()->location)
                                            ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $personalTotal }}</h1>
                    <div class="stat-percent font-bold text-navy"><i class="fa fa-handshake-o"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-warning">Job Visits</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $jobTotal = \App\Visitor::where('purpose', 'Job Visits')->count();
                        } else {
                            $jobTotal = \App\Visitor::where('purpose', 'Job Visits')
                                    ->where('building_location', auth()->user()->location)
                                    ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $jobTotal }}</h1>
                    <div class="stat-percent font-bold text-warning"><i class="fa fa-search"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-warning">Employee</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $jobTotal = \App\Visitor::where('purpose', 'Employee')->count();
                        } else {
                            $jobTotal = \App\Visitor::where('purpose', 'Employee')
                                    ->where('building_location', auth()->user()->location)
                                    ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $jobTotal }}</h1>
                    <div class="stat-percent font-bold text-warning"><i class="fa fa-search"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-warning">For Interview</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $jobTotal = \App\Visitor::where('purpose', 'For Interview')->count();
                        } else {
                            $jobTotal = \App\Visitor::where('purpose', 'For Interview')
                                    ->where('building_location', auth()->user()->location)
                                    ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $jobTotal }}</h1>
                    <div class="stat-percent font-bold text-warning"><i class="fa fa-search"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-warning">Interns/Trainees</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $jobTotal = \App\Visitor::where('purpose', 'Interns/Trainees')->count();
                        } else {
                            $jobTotal = \App\Visitor::where('purpose', 'Interns/Trainees')
                                    ->where('building_location', auth()->user()->location)
                                    ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $jobTotal }}</h1>
                    <div class="stat-percent font-bold text-warning"><i class="fa fa-search"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="text-warning">Client</h5>
                </div>
                <div class="ibox-content">
                    @php
                        if (auth()->user()->location === null) {
                            $jobTotal = \App\Visitor::where('purpose', 'Client')->count();
                        } else {
                            $jobTotal = \App\Visitor::where('purpose', 'Client')
                                    ->where('building_location', auth()->user()->location)
                                    ->count();
                        }
                    @endphp
                    <h1 class="no-margins">{{ $jobTotal }}</h1>
                    <div class="stat-percent font-bold text-warning"><i class="fa fa-search"></i></div>
                    <small>Total Visit</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Visitors</h5>
                </div>
                <div class="ibox-content">
                    <div class="wrapper wrapper-content animated fadeIn">
                        <div class="row">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">Active</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2">Returned ID</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive dataTables">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Visitor</th>
                                                            <th>Building Name</th>
                                                            <th>Tenant Name</th>
                                                            <th>Purpose</th>
                                                            <th>Date Entered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach($visitors->where('return_id', null) as $visitor) --}}
                                                        @foreach($activeVisitors as $visitor)
                                                            {{-- @if(auth()->user()->location == $visitor->building_location || (auth()->user()->name == 'Admin')) --}}
                                                            <tr  title="View Information" class="view-visitor" data-id="{{ $visitor->id }}" style="cursor:pointer">
                                                                <td>
                                                                    <img class="img-visitor" loading="lazy" src="{{$visitor->image}}">
                                                                </td>
                                                                <td>{{$visitor->name}}</td>
                                                                <td>
                                                                    {{ $visitor->building->name ?? '-' }}
                                                                </td>
                                                                <td>{{$visitor->tenant_name}}</td>
                                                                <td>{{$visitor->purpose}}</td>
                                                                <td>{{$visitor->created_at->format('m/d/Y h:i:s A')}}</td>
                                                            </tr>
                                                            {{-- @endif --}}
                                                        @endforeach
                                                    </tbody>
                                                    {{ $activeVisitors->links() }}
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive dataTables">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Visitor</th>
                                                            <th>Building Name</th>
                                                            <th>Tenant Name</th>
                                                            <th>Purpose</th>
                                                            <th>Date Entered</th>
                                                            <th>Date Exited</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach($visitors->where('return_id', 1) as $visitor) --}}
                                                        @foreach($returnedVisitors as $visitor)
                                                            {{-- @if(auth()->user()->location == $visitor->building_location || (auth()->user()->name == 'Admin')) --}}
                                                            <tr title="View Information" class="view-visitor" data-id="{{ $visitor->id }}">
                                                                <td>
                                                                    <img class="img-visitor" src="{{$visitor->image}}" loading="lazy">
                                                                </td>
                                                                <td>{{$visitor->name}}</td>
                                                                <td>
                                                                    {{ $visitor->building->name ?? '-' }}
                                                                </td>
                                                                <td>{{$visitor->tenant_name}}</td>
                                                                <td>{{$visitor->purpose}}</td>
                                                                <td>{{$visitor->created_at->format('m/d/Y h:i:s A')}}</td>
                                                                <td>{{$visitor->updated_at->format('m/d/Y h:i:s A')}}</td>
                                                            </tr>
                                                            {{-- @endif --}}
                                                        @endforeach
                                                    </tbody>
                                                    {{ $returnedVisitors->links() }}
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="visitorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="visitorModalContent">
        </div>
    </div>
</div>


<style>
    .stat-percent {
        font-size: 20px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).on('click', '.view-visitor', function () {
    let id = $(this).data('id');

    $('#visitorModalContent').html('<div class="p-4 text-center">Loading...</div>');

    $('#visitorModalContent').load('visitor/' + id, function () {
        $('#visitorModal').modal('show');
    });
});
</script>
@endsection