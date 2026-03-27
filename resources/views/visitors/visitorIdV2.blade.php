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
                                    {{-- <form method="GET" id="searchForm"> --}}
                                        <div>
                                            <input type="text" id="search" name="search" value="" placeholder="Search..." style="padding:5px; border:1px solid #ccc; border-radius:4px;">
                                            {{-- <button type="submit" class="btn btn-default btn-sm">Search</button> --}}
                                        </div>
                                    {{-- </form> --}}
                                    <div>
                                        <a id="btnCsv" href="{{ url('/visitors/export/csv') }}" class="btn btn-default btn-sm">CSV</a>
                                        <a id="btnExcel" href="{{ url('/visitors/export/excel') }}" class="btn btn-default btn-sm">Excel</a>
                                        <a id="btnPdf" href="{{ url('/visitors/export/pdf') }}" class="btn btn-default btn-sm">PDF</a>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover table-responsive dataTables-visitor" id="dataTables-visitor">
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
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    $(document).ready(function () {
        let orderTable = $('#dataTables-visitor').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            ordering: false,
            paging: true,
            autoWidth: false,
            lengthChange: true,
            language: {
                processing: '<div class="spinner-border"></div>',
            },
            ajax: function (data, callback) {
                let page = (data.start / data.length) + 1;
                let limit = data.length;

                $.ajax({
                    url: "{{ route('visitors.list') }}",
                    type: 'GET',
                    data: {
                        page: page,
                        limit: limit,
                        search: $('#search').val()
                    },
                    success: function (resp) {
                        callback({
                            data: resp.data,            
                            recordsTotal: resp.total,   
                            recordsFiltered: resp.total 
                        });
                    }
                });
            },
            columns: [
                { 
                    data: 'visitor_id',
                    createdCell: function (td, cellData) {
                        if (!cellData) {
                            $(td).css('background-color', '#f14d4d');
                            $(td).css('color', '#fff');
                        }
                    }
                },
                {
                    render: function (data, type, row) {
                        return `<img class="img-visitor" src="${row.image}">`
                    }
                },
                { data: 'name'},
                { data: 'created_at'},
                { data: 'tenant_name'},
                { data: 'purpose'},
                {
                    width: '8%',
                    className: 'text-center',
                    render: function (data, type, row) {
                        let button = '';
                        if (row.visitor_id == null) {
                            button = `<button type="button" class="btn btn-success btn-outline" title="Issue Visitor ID" data-toggle="modal" data-target="#"><i class="fa fa fa-plus"></i><a href="#"></a></button>`
                        }else{
                            button = `<a href="#" class="btn btn-danger btn-outline" title="Return ID"><i class="fa fa-repeat"></i></a>`
                        }
                        return button;
                    }
                }
            ],
            rowCallback : function(row,data,DisplayIndex){
            }
        });

        $('#search').on('input', function () {
            ReloadDataTable();
        });

        function ReloadDataTable() {
            orderTable.ajax.reload(null, true);
        }
    });
</script>
@endsection