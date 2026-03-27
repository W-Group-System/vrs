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
                                    <form method="GET" action="">
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
        
    });
</script>
@endsection