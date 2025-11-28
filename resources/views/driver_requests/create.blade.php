<div class="">
    <div class="alert alert-danger">
        <strong>The quick driver request is only for same day town running requests. Long distance activities should be submitted in FMS</strong>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('driver_requests.store') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{csrf_field()}}
                        <input type="hidden" id="created_by" name="{{ isset($driver_request) ? 'updated_by' : 'created_by' }}" value="{{ $username }}">
                        @if(isset($driver_request))
                            <input type="hidden" name="id" value="{{ $driver_request->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="request_date" class="col-md-4 col-form-label text-md-right text-bold">Request Date:</label> 
                            <div class="col-md-8">
                                <input type="text" name="request_date" value="{{ (isset($driver_request)?full_year_format_date($driver_request->request_date): date('j M Y')) }}" class="form-control calendar" required id="request_date"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="request_by" class="col-md-4 col-form-label text-md-right text-bold">Request By:</label> 
                            <div class="col-md-8">
                                <input type="text" name="request_by" id="request_by" value="{{ isset($driver_request) ? $driver_request->request_by : $username }}" class="form-control" required readonly/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="request_for" class="col-md-4 col-form-label text-md-right text-bold">Request For:</label>
                            <div class="col-md-8">
                                <select name="request_for" id="request_for" required class="form-control selectize">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="destination" class="col-md-4 col-form-label text-md-right">{{ __('Destination:') }}</label>
                            <div class="col-md-8">
                                <textarea name="destination" id="destination" type="text" class="form-control" required>{{ (isset($driver_request)?$driver_request->destination:'') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="drop_off_date" class="col-md-4 col-form-label text-md-right text-bold">Dropoff Date:</label> 
                            <div class="col-md-4">
                                <input type="date" name="drop_off_date" id="drop_off_date" value="{{ isset($driver_request) ? $driver_request->drop_off_date : '' }}" class="form-control" required/>
                            </div>
                            <div class="col-md-4">
                                <input type="time" name="drop_off_time"  id="drop_off_time" value="{{ isset($driver_request) ? $driver_request->drop_off_time : '' }}" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pick_up_date" class="col-md-4 col-form-label text-md-right text-bold">Pickup Date:</label> 
                            <div class="col-md-4">
                                <input type="date" name="pick_up_date" id="pick_up_date" value="{{ isset($driver_request) ? $driver_request->pick_up_time : '' }}" class="form-control" readonly/>
                            </div>
                            <div class="col-md-4">
                                <input type="time" name="pick_up_time" id="pick_up_time" value="{{ isset($driver_request) ? $driver_request->pick_up_time : '' }}" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary sendDriverRequest pull-right">Save Driver Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        populateUserSelect();

        function populateUserSelect() {
            $('#request_for').empty();
            let current_users = JSON.parse(localStorage.getItem('active_users'));
            if (current_users && current_users.payload && current_users.payload.data) {
                let users = current_users.payload.data;
                let curre_user = $('#request_by').val();
                let found_user = users.find(user => user.username === curre_user);
                console.log('found_user', found_user);
         
                $('#request_for').append(`<option value="${found_user.username}" selected>${found_user.first_name} ${found_user.last_name}</option>`);
                $.each(users, function(index, user) {
                    let fullName = user.first_name + " " + user.last_name;
                    $('#request_for').append(`<option value="${user.username}">${fullName}</option>`);
                });
            } else {
                console.error('No active users found');
            }
        }
    });
</script>
