@php 
$image_path_front = '/storage_front';
$image_path_back = '/storage_back';
@endphp
<form action="{{route('fuel_issues.store')}}" class="form-horizontal custom_response just_reload valid_fuel_issue" method="post" id="form_{{time()}}">
    @csrf
    <input type="hidden" name="ext" value="1">
    <input type="hidden" name="data_source" value="{{ DATA_SOURCE_LOGIN_APP }}">
    <input type="hidden" name="created_by" value="{{$username}}" id="created_by">
    <div class="row" style="display: flex;padding: 5px 10px">
        <div class="col-md-8">
            <div class="row">
                {{-- Back --}}
                <div class="col-md-6 fuel_issue_review_section">
                    <div class="preview_header">Back Image</div>
                    <div class="form-group row">
                        <label for="back_picture" class="col-md-4 col-form-label text-md-right text-bold">Back Picture:</label> 
                        <div class="col-md-4">
                            <input type="file" name="back_picture" id="back_picture" value="{{ isset($issue) ? $issue->back_picture : '' }}" accept="image/*" onchange="previewImage(event, 'back_image_preview')">
                        </div>
                    </div>
                    <div>
                        <img id="back_image_preview" src="" alt="Back Image Preview" style="max-width: 300px; display: none;">
                    </div>
                </div>
                {{-- Front --}}
                <div class="col-md-6 fuel_issue_review_section">
                    <div class="preview_header">Front Image</div>
                    <div class="form-group row">
                        <label for="front_picture" class="col-md-4 col-form-label text-md-right text-bold">Front Picture:</label> 
                        <div class="col-md-4">
                            <input type="file" name="front_picture" id="front_picture" value="{{ isset($issue) ? $issue->front_picture :'' }}" accept="image/*" onchange="previewImage(event, 'front_image_preview')">
                        </div>
                    </div>
                    <div>
                        <img id="front_image_preview" src="" alt="Back Image Preview" style="max-width: 300px; display: none;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 fuel_issue_review_section">
                <div class="preview_header">Fuel Issue Details</div>
                {{--  Request Type   --}}
                <div class="form-group row fuel_issue_field_mb">
                    <label class="col-md-4 col-form-label text-md-right fuel_issue_field_sz">Fuel Type:</label>
                    <div class="col-md-8">
                        <select name="fuel_type" id="fuel_type" required class="form-control selectize">
                            @foreach(['Diesel', 'Petrol'] as $fuel)
                                <option value="{{$fuel}}">{{$fuel}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{--  Request Type   --}}
                <div class="form-group row fuel_issue_field_mb">
                    <label class="col-md-4 col-form-label text-md-right">Issued to Driver:</label>
                    <div class="col-md-8">
                        <select name="issue_driver" id="issue_driver" class="form-control selectize" required>
                            <option value="" selected>-Select Driver-</option>
                            @if(isset($users) && count($users) > 0)
                                @foreach($users as $user)
                                    <option value="{{$user['username']}}">{{$user['first_name']}} {{$user['last_name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row fuel_issue_field_mb">
                    <label class="col-md-4 col-form-label text-md-right">Issued to Vehicle:</label>
                    <div class="col-md-8">
                        <select name="issue_vehicle_id" id="issue_vehicle_id" class="form-control selectize" required>
                            <option value="" selected>-Select Vehicle-</option>
                            @if(isset($vehicles) && count($vehicles) > 0)
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['id']}}">{{$vehicle['number_plate']}}</option>
                                    {{-- <option value="{{$vehicle->id}}">{{$vehicle->number_plate}}</option> --}}
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row fuel_issue_field_mb">
                    <label for="issue_date" class="col-md-4 col-form-label text-md-right text-bold">Fuel Issue Date:</label> 
                    <div class="col-md-8">
                        <input type="text" name="issue_date" class="form-control calendar" required id="issue_date"/>
                    </div>
                </div>
                <div class="form-group row fuel_issue_field_mb">
                    <label for="issue_amount" class="col-md-4 col-form-label text-md-right text-bold">Fuel Issue Amount:</label> 
                    <div class="col-md-8">
                        <input type="number" name="issue_amount" id="issue_amount" class="form-control" required id="issue_amount"/>
                    </div>
                </div>
                <div class="row " style="margin-top: 20px">
                    <div class="col-md-12 align-right">
                        <button type="submit" class="btn btn-success ajax-get redirect fuel_issue_confirmation btnSubmit">
                            Save Fuel Issue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>