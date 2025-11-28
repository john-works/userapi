<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('calendar_users.store') }}" method="post" class="form-horizontal response_with_id" id="form_{{ time() }}">
                        {{csrf_field()}}
                        <input type="hidden" name="{{ isset($calendar_user) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($calendar_user))
                            <input type="hidden" name="id" value="{{ $calendar_user->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="calendar_id" class="col-md-4 col-form-label text-md-right text-bold">Calendar:</label>
                            <div class="col-md-8">
                                <select name="calendar_id" id="calendar_id" required class="form-control selectize">
                                    <option value="{{(isset($calendar_user)? $calendar_user->calendar_id: '' )}}" selected >
                                        {{(isset($calendar_user)&&isset($calendar_user->calendar->name))? $calendar_user->calendar->name: 'Select Calendar' }}
                                    </option>
                                    @if(isset($calendars) && count($calendars) > 0)
                                        @foreach($calendars as $calendar)
                                            <option value="{{$calendar->id}}">{{$calendar->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right text-bold">User:</label>
                            <div class="col-md-8">
                                <select name="user_id" id="user_id" required class="form-control selectize">
                                    <option value="{{(isset($calendar_user)? $calendar_user->user_id: '' )}}" selected >
                                        {{(isset($calendar_user)&&isset($calendar_user->user->name))? $calendar_user->user->name: 'Select User' }}
                                    </option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{$user->username}}">{{$user->fullName}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-inline row">
                            <label for="can_edit" class="col-md-4 col-form-label text-md-right text-bold">Can Edit:</label>
                            <div class="col-md-8">
                                <div class="form-group mx-2">
                                    <input type="radio" class="form-check-input" id="can_edit" name="can_edit" value="yes">
                                    <label class="form-check-label" for="yes">Yes</label>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-group mx-2">
                                    <input type="radio" class="form-check-input" id="cannot_edit" name="can_edit" value="no" checked>
                                    <label class="form-check-label" for="no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($calendar_user) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
