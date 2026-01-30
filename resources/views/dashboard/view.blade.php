<div class="modal-header">
    <h3 class="modal-title">Visitor Information</h3>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6 mb-10">
            <strong>Visitor Name:</strong> {{ $visitor->name }}
        </div>
        <div class="col-md-6 mb-10">
            <strong>Tenant Name:</strong> {{ $visitor->tenant_name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-10">
            <strong>Purpose:</strong> {{ $visitor->purpose }}
        </div>
        <div class="col-md-6 mb-10">
            <strong>Date Entered:</strong>
            {{ $visitor->created_at->format('m/d/Y - h:i:s A') }}
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-lg-6 text-center">
            <img class="resize" src="{{ $visitor->scan_id }}">
            <h4>Scanned ID</h4>
        </div>
        <div class="col-lg-6 text-center">
            <img class="resize" src="{{ $visitor->image }}">
            <h4>Image</h4>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
