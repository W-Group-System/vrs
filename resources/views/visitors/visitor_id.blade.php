@extends('layouts.header')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin: 5px 5px 0px 5px;">Visitor ID List</h5>
                </div>
                <div class="ibox-content">
                    <div class="wrapper wrapper-content animated fadeIn">
                        <div class="row">
                            <div class="table-responsive">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <form method="GET" action="{{ url('/visitor_id') }}">
                                        <div>
                                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search..." style="padding:5px; border:1px solid #ccc; border-radius:4px;">
                                            <button type="submit" class="btn btn-default btn-sm">Search</button>
                                        </div>
                                    </form>
                                    <div>
                                        <a id="btnCsv" href="{{ url('/visitors/export/csv') }}" class="btn btn-default btn-sm">CSV</a>
                                        <a id="btnExcel" href="{{ url('/visitors/export/excel') }}" class="btn btn-default btn-sm">Excel</a>
                                        <a id="btnPdf" href="{{ url('/visitors/export/pdf') }}" class="btn btn-default btn-sm">PDF</a>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover table-responsive dataTables-visitor">
                                    <thead>
                                        <tr>
                                            <th>Visitor ID</th>
                                            <th>Image</th>
                                            <th>Visitor Name</th>
                                            <th>Date Entered</th>
                                            <th>Tenant Name</th>
                                            <th>Purpose</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($visitors as $visitor)
                                            {{-- @if(auth()->user()->location == $visitor->building_location || (auth()->user()->name == 'Admin')) --}}
                                            <tr>
                                                @if ($visitor->visitor_id === null)
                                                    <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" style="background-color: #f14d4d" width="10%">{{$visitor->visitor_id}}</td>
                                                @else
                                                    <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="10%">{{$visitor->visitor_id}}</td>
                                                @endif
                                                <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="8%"><img class="img-visitor" src="{{ $visitor->image }}"></td>
                                                <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="22%">{{$visitor->name}}</td>
                                                <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="17%">{{$visitor->created_at->format('m/d/Y h:i:s A')}}</td>
                                                <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="20%">{{$visitor->tenant_name}}</td>
                                                <td class="visitor-view" data-visitor-id="{{ $visitor->id }}" width="15%">{{$visitor->purpose}}</td>
                                                <td width="8%" align="center">
                                                    <!-- <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" title="View Information" data-target="#view_id{{ $visitor->id }}"><i class="fa fa-eye"></i></button> -->
                                                    @if ($visitor->visitor_id === null)
                                                        <button type="button" class="btn btn-success btn-outline" title="Issue Visitor ID" data-toggle="modal" data-target="#add_id{{ $visitor->id }}"><i class="fa fa fa-plus"></i><a href="{{ url('new_id/' .$visitor->id) }}"></a></button>
                                                        <a href="{{ url('return_id/' . $visitor->id) }}" class="btn btn-danger btn-outline" title="Return ID" style="display: none"><i class="fa fa-repeat"></i></a>
                                                    @else
                                                        <button type="button" style="display: none" class="btn btn-success btn-outline" title="Issue Visitor ID" data-toggle="modal" data-target="#add_id{{ $visitor->id }}"><i class="fa fa fa-plus"></i><a href="{{ url('new_id/' .$visitor->id) }}"></a></button>
                                                        <a href="{{ url('return_id/' . $visitor->id) }}" class="btn btn-danger btn-outline" title="Return ID"><i class="fa fa-repeat"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $visitors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="add_visitor_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="addUserForm" method="POST" action="{{ url('new_user') }}" autocomplete="off">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Add User</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-10">
                            <label>Set ID Number</label>
                            <input name="name" id="name" class="form-control" type="text" placeholder="Enter ID Number">
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="submitForm()">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div> -->
@foreach($visitors as $visitor)
    @include('visitors.edit')
@endforeach
@foreach($visitors as $visitor)
    @include('visitors.view')
@endforeach
@endsection
@section('footer')
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

<script>
    $(document).ready(function(){
    /*
        $('.dataTables-visitor').DataTable({
            pageLength: 25,
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'csv', title: 'Visitor List'},
                {extend: 'excel', title: 'Visitor List'},
                {extend: 'pdf', title: 'Visitor List'},
            ]
        });
        */
    });

    $(document).ready(function() {
        $('.visitor-view').click(function() {
            var visitorId = $(this).data('visitor-id');
            
            $(this).attr('data-toggle', 'modal');
            $(this).attr('title', 'View Information');
            $(this).attr('data-target', '#view_id' + visitorId);
        });
    });
</script>
@endsection