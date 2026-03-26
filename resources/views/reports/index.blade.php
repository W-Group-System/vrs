@extends('layouts.header')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin: 5px 5px 0px 5px;">Reports List</h5>
                </div>
                <div class="ibox-content">
                    <div class="wrapper wrapper-content animated fadeIn">
                        <div class="row">
                            <div class="row mt-10 mb-10">
                                <div class="col-md-3">
                                    <div class="ibox-content ibox-report text-center">
                                        <h1 class="no-margins">{{ $visitorTotal }}</h1>
                                        <div class="stat-percent font-bold">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <medium>Total Visitor</medium>
                                    </div>
                                </div>
                            </div>
                            <form method="GET" action="{{ url('/report') }}">
                                <div class="row mb-10">
                                    <div class="col-md-3">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date" id="form_start_date"
                                            value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date" id="form_end_date"
                                            value="{{ request('end_date') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Search</label>
                                        <input type="text" class="form-control" name="search" id="search"
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2" style="margin-top: 25px;">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <div>
                                        <button id="btnCsv" class="btn btn-default btn-sm">CSV</button>
                                        <button id="btnExcel" class="btn btn-default btn-sm">Excel</button>
                                        <button id="btnPdf" class="btn btn-default btn-sm">PDF</button>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Visitor ID</th>
                                            <th>Image</th>
                                            <th>Visitor Name</th>
                                            <th>Tenant Name</th>
                                            <th>Purpose</th>
                                            <th>Date Entered</th>
                                            <th>Date Exited</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($visitors as $visitor)
                                            @if(auth()->user()->location == $visitor->building_location || auth()->user()->name == 'Admin')
                                            <tr>
                                                <td>{{ $visitor->visitor_id ? $visitor->visitor_id : 'N/A' }}</td>
                                                <td><img class="img-visitor" src="{{ $visitor->image }}"></td>
                                                <td>{{ $visitor->name }}</td>
                                                <td>{{ $visitor->tenant_name }}</td>
                                                <td>{{ $visitor->purpose }}</td>
                                                <td>{{ $visitor->created_at->format('m/d/Y h:i:s A') }}</td>
                                                <td>{{ $visitor->updated_at ? $visitor->updated_at->format('m/d/Y h:i:s A') : 'None' }}</td>
                                            </tr>
                                            @endif
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
<form id="printReportForm" method="POST">
    @csrf
    <input type="hidden" value="{{ request('start_date') }}" name="start_date" id="print_start_date">
    <input type="hidden" value="{{ request('end_date') }}" name="end_date" id="print_end_date">
</form>

<style>
    .ibox-report {
        color: #fff;
        background-color: #1ab394;
        border-radius: 5px;
    }
    .mt-15 {
        margin-top: 15px;
    }
</style>
@endsection
@section('footer')
<script>
    $(document).ready(function () {

        $('#form_start_date').on('change', function () {
            let startDate = $(this).val();
            $('#print_start_date').val(startDate);
        });
        $('#form_end_date').on('change', function () {
            let endtDate = $(this).val();
            $('#print_end_date').val(endtDate);
        });

        $('#btnCsv').on('click', function () {
            let form = $('#printReportForm');
            form.attr("action","{{ route('report.csv') }}");
            form.trigger('submit');
        });
        $('#btnExcel').on('click', function () {
            let form = $('#printReportForm');
            form.attr("action","{{ route('report.excel') }}");
            form.trigger('submit');
        });
        $('#btnPdf').on('click', function () {
            let form = $('#printReportForm');
            form.attr("action","{{ route('report.pdf') }}");
            form.trigger('submit');
        });
    });
</script>
@endsection
