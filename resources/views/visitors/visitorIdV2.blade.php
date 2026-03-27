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
                                    <form method="GET" id="searchForm">
                                        <div>
                                            <input type="text" id="search" name="search" value="" placeholder="Search..." style="padding:5px; border:1px solid #ccc; border-radius:4px;">
                                            <button type="submit" class="btn btn-default btn-sm">Search</button>
                                        </div>
                                    </form>
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
<div class="modal fade" id="editVisitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" id="editVisitorForm">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">ID Number</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px; color: red; font-size: 25px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId" value="">
                    <div class="row">
                        <div class="col-12 mb-10">
                            <label>Set ID Number</label>
                            <input name="visitor_id" id="visitor_id" class="form-control" type="text" placeholder="Enter ID Number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btnSave">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    width: '8%',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return `<i class="fa fa-image"></i>`
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
                        // if (row.visitor_id == null) {
                            button = `<button type="button" class="btn btn-success btn-outline btnEdit" title="Issue Visitor ID"><i class="fa fa fa-plus"></i><a href="#"></a></button>`
                        // }else{
                        //     button = `<a href="#" class="btn btn-danger btn-outline" title="Return ID"><i class="fa fa-repeat"></i></a>`
                        // }
                        return button;
                    }
                }
            ],
            rowCallback : function(row,data,DisplayIndex){
                $(row).find('.btnEdit').unbind('click').on('click',function(){
                    $('#editId').val(data.id);
                    $('#editVisitor').modal('show');
                });
            }
        });

        $('#searchForm').submit(function (e) { 
            e.preventDefault();
            ReloadDataTable();
        });

        $('#editVisitorForm').submit(function (e) { 
            e.preventDefault();
            let form = $(this);
            var form_data = $(this).serializeArray();
            $.ajax({
                type: "POST",
                url: "{{ route('visitor.create.id') }}",
                data: form_data,
                // contentType:"application/json",
                beforeSend: function(){
                    $('.btnSave').prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                },
                success: function (response) {
                    ReloadDataTable();
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success'
                    });
                },
                error: function (xhr) {
                    $('#editVisitor').modal('hide');
                    Swal.fire('Error',xhr.responseJSON?.message || 'Error','error');
                },
                complete: function(){
                    $('#editVisitor').modal('hide');
                    $('.btnSave').prop('disabled',false).text('Process');
                }
            });
            // 
        });


        $('#editVisitor').on('hide.bs.modal', function () {
            $('#editId').val();
            $('#editVisitorForm').trigger('reset');
        });
        function ReloadDataTable() {
            orderTable.ajax.reload(null, false);
        }
    });
</script>
@endsection