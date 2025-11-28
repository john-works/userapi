<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('actionlog_tasks.store') }}" method="post" class="form-horizontal custom_response" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($statusupdate) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($statusupdate))
                            <input type="hidden" name="id" value="{{ $statusupdate->id }}">
                        @endif
                        @if(isset($actionlog))
                        <input type="hidden" name="actionlog_id" value="{{ $actionlog->id }}" required>
                        @endif
                        <div class="form-group row">
                            <label for="next_action_department_name" class="col-md-4 col-form-label text-md-right text-bold">New Task Department:</label>
                            <div class="col-md-8">
                                <select name="next_action_department_name" id="next_action_department_name" class="form-control selectize" required>
                                    <option value="" selected disabled>
                                    Select Department
                                    </option>
                                    @if(isset($departments) && count($departments) > 0)
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_action_unit_name" class="col-md-4 col-form-label text-md-right text-bold">New Task Unit:</label>
                            <div class="col-md-8">
                                <select name="next_action_unit_name" id="next_action_unit_name" class="form-control selectize" required>
                                    <option value="{{(isset($actionlog)? $actionlog->unit_id: '' )}}" selected >
                                        {{(isset($actionlog)&&isset($actionlog->unit->name))? $actionlog->unit->name: 'Select Unit' }}
                                    </option>
                                    @if(isset($units) && count($units) > 0)
                                        @foreach($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_action_user" class="col-md-4 col-form-label text-md-right text-bold">New Task User:</label>
                            <div class="col-md-8">
                                <select name="next_action_user" id="next_action_user" class="form-control selectize" required>
                                    <option value="{{(isset($statusupdate)? $statusupdate->user_id: '' )}}" selected >
                                        {{(isset($statusupdate)&&isset($statusupdate->user->name))? $statusupdate->user->name: 'Select New Task User' }}
                                    </option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{$user->username}}">{{$user->fullname}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_action" class="col-md-4 col-form-label text-md-right text-bold">New Task Details:</label>
                            <div class="col-md-8">
                                <textarea type="text" name="next_action" id="next_action" class="form-control" rows="3" required>{{ isset($statusupdate) ? $statusupdate->next_action : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_action_date" class="col-md-4 col-form-label text-md-right text-bold">
                                Planned Completion Date:
                            </label>
                            <div class="col-md-8">
                                <input type="date" name="next_action_date" id="next_action_date" value="{{ isset($statusupdate) ? $statusupdate->next_action_date : '' }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($statusupdate) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
