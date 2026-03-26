<div class="modal fade" id="view_id{{$visitor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Visitor Information</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px; color: red; font-size: 25px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-10">
                        <label class="col-form-h4">Visitor Name:</label>
                        <label class="col-form-h4" style="font-weight: 500">&nbsp;{{$visitor->name}}</label>
                    </div>
                    <div class="col-md-6 mb-10">
                        <label class="col-form-h4">Tenant Name:</label>
                        <label class="col-form-h4" style="font-weight: 500">&nbsp;{{$visitor->tenant_name}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-10">
                        <label class="col-form-h4">Building Name:</label>
                        <label class="col-form-h4" style="font-weight: 500">&nbsp;
                            @foreach($buildings as $building)
                                @if($building->id == $visitor->building_location)
                                    {{ $building->name }}
                                @endif
                            @endforeach
                        </label>
                    </div>
                    <div class="col-md-6 mb-10">
                        <label class="col-form-h4">Date Entered:</label>
                        <label class="col-form-h4" style="font-weight: 500">&nbsp;{{$visitor->created_at->format('m/d/Y - h:i:s A')}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6" align="center">
                        <img class="resize" src="{{ url('/visitors/scan_id/'.$visitor->id) }}">
                        <h3 class="mt-20">Scanned ID</h3>
                    </div>
                    <div class="col-lg-6" align="center">
                        <img class="resize" src="{{ url('/visitors/image/'.$visitor->id) }}">
                        <h3 class="mt-20">Image</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    .mt-20 {
        margin-top: 20px;
    }
    .resize {
        height: 350px;
        width: 400px;
    }
    .col-form-h4 {
        font-size: 16px;
    }
</style>