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
                                                <table class="table table-striped table-bordered table-hover table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Visitor</th>
                                                            <th>Building Name</th>
                                                            <th>Tenant Name</th>
                                                            <th>Purpose</th>
                                                            <th>Date Entered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($visitors->where('return_id', null) as $visitor)
                                                            @if(auth()->user()->location == $visitor->building_location || (auth()->user()->name == 'Admin'))
                                                            <tr data-toggle="modal" title="View Information" data-target="#view_active{{ $visitor->id }}">
                                                                <td>
                                                                    <img class="img-visitor" src="{{$visitor->image}}">&nbsp;&nbsp;{{$visitor->name}}
                                                                </td>
                                                                <td>
                                                                    {{-- @foreach($buildings as $building)
                                                                        @if($building->id == $visitor->building_location)
                                                                            {{ $building->name }}
                                                                        @endif
                                                                    @endforeach --}}
                                                                    <td>{{ $visitor->building->name ?? '-' }}</td>
                                                                </td>
                                                                <td>{{$visitor->tenant_name}}</td>
                                                                <td>{{$visitor->purpose}}</td>
                                                                <td>{{$visitor->created_at->format('m/d/Y h:i:s A')}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                    {{-- {{ $activeVisitors->links() }} --}}
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Visitor</th>
                                                            <th>Building Name</th>
                                                            <th>Tenant Name</th>
                                                            <th>Purpose</th>
                                                            <th>Date Entered</th>
                                                            <th>Date Exited</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($visitors->where('return_id', 1) as $visitor)
                                                            @if(auth()->user()->location == $visitor->building_location || (auth()->user()->name == 'Admin'))
                                                            <tr data-toggle="modal" title="View Information" data-target="#view_return{{ $visitor->id }}">
                                                                <td>
                                                                    <img class="img-visitor" src="{{$visitor->image}}">&nbsp;&nbsp;{{$visitor->name}}
                                                                </td>
                                                                <td>
                                                                    {{-- @foreach($buildings as $building)
                                                                        @if($building->id == $visitor->building_location)
                                                                            {{ $building->name }}
                                                                        @endif
                                                                    @endforeach --}}
                                                                    <td>{{ $visitor->building->name ?? '-' }}</td>
                                                                </td>
                                                                <td>{{$visitor->tenant_name}}</td>
                                                                <td>{{$visitor->purpose}}</td>
                                                                <td>{{$visitor->created_at->format('m/d/Y h:i:s A')}}</td>
                                                                <td>{{$visitor->updated_at->format('m/d/Y h:i:s A')}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                    {{-- {{ $returnedVisitors->links() }} --}}
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
@foreach($visitors as $visitor)
    @include('dashboard.view')
@endforeach
<style>
    .stat-percent {
        font-size: 20px;
    }
</style>

@endsection