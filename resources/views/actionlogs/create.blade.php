<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('actionlogs.store') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($actionlog) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($actionlog))
                            <input type="hidden" name="id" value="{{ $actionlog->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="actionlog_type" class="col-md-4 col-form-label text-md-right text-bold">Action Log Type:</label>
                            <div class="col-md-8">
                                @if($menu_selected == MENU_ITEM_ACTIONLOGS)
                                <select name="actionlog_type" id="actionlog_type" required class="form-control selectize">
                                    <option value="{{(isset($actionlog)? $actionlog->actionlog_type: '' )}}" selected>
                                        {{(isset($actionlog)&&isset($actionlog->actionlog_type))? $actionlog->actionlog_type: 'Select Department' }}
                                    </option>
                                    @if(isset($actionlog_types) && count($actionlog_types) > 0)
                                        @foreach($actionlog_types as $actionlog_type)
                                            <option value="{{$actionlog_type->department_name}}" {{ session('user')->departmentCode == $actionlog_type->department_code ? 'selected' : '' }}>{{$actionlog_type->department_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @elseif($menu_selected == MENU_ITEM_ACTIONLOGS_BOARD)
                                <input type="text" name="actionlog_type" value="{{DEPARTMENT_BOARD}}" class="form-control" required readonly>
                                @elseif($menu_selected == MENU_ITEM_ACTIONLOGS_EXCO)
                                <input type="text" name="actionlog_type" value="{{DEPARTMENT_EXCO}}" class="form-control" required readonly>
                                @else
                                <input type="text" name="actionlog_type" value="{{session('user')->departmentName}}" class="form-control" readonly>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="required_action" class="col-md-4 col-form-label text-md-right text-bold">Required Action:</label>
                            <div class="col-md-8">
                                <textarea type="text" name="required_action" class="form-control" required id="required_action" rows="4">{{ isset($actionlog) ? $actionlog->required_action : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="responsible_department" class="col-md-4 col-form-label text-md-right text-bold">Responsible Department:</label>
                            <div class="col-md-8">
                                <select name="responsible_department" id="responsible_department" required class="form-control selectize">
                                    <option value="{{(isset($actionlog)? $actionlog->department_id: '' )}}" selected >
                                        {{(isset($actionlog)&&isset($actionlog->department->name))? $actionlog->department->name: 'Select Department' }}
                                    </option>
                                    @if(isset($departments) && count($departments) > 0)
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" {{ session('user')->departmentId == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="responsible_person" class="col-md-4 col-form-label text-md-right text-bold">Responsible Person:</label>
                            <div class="col-md-8">
                                <select name="responsible_person" id="responsible_person" required class="form-control selectize">
                                    <option value="{{(isset($actionlog)? $actionlog->responsible_person: '' )}}" selected >
                                        {{(isset($actionlog)&&isset($actionlog->responsible_person))? getFullname($actionlog->responsible_person): 'Select Responsible Person' }}
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
                            <label for="reference_number" class="col-md-4 col-form-label text-md-right text-bold">Reference Number:</label>
                            <div class="col-md-8">
                                <input type="text" name="reference_number" id="reference_number" class="form-control" value="{{ isset($actionlog) ? $actionlog->reference_number : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_opened" class="col-md-4 col-form-label text-md-right text-bold">Date Opened:</label>
                            <div class="col-md-8">
                                <input type="date" name="date_opened" id="date_opened" class="form-control" value="{{ isset($actionlog) ? $actionlog->date_opened : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="initial_due_date" class="col-md-4 col-form-label text-md-right text-bold">Initial Due Date:</label>
                            <div class="col-md-8">
                                <input type="date" name="initial_due_date" id="initial_due_date" class="form-control" value="{{ isset($actionlog) ? $actionlog->initial_due_date : '' }}">
                            </div>
                        </div>
                        @if(isset($actionlog))
                        <div class="form-group row">
                            <label for="revised_due_date" class="col-md-4 col-form-label text-md-right text-bold">Revised Due Date:</label>
                            <div class="col-md-8">
                                <input type="date" name="revised_due_date" id="revised_due_date" class="form-control" value="{{ isset($actionlog) ? $actionlog->revised_due_date : '' }}">
                            </div>
                        </div>
                        @endif
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit" id="checkActionlogCreator">
                                    {{ isset($actionlog) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
