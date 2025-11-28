<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('action_log_types.store') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($action_log_type) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($action_log_type))
                            <input type="hidden" name="id" value="{{ $action_log_type->id }}">
                        @endif
                        <input type="hidden" name="action_log_type_id" value="{{$action_log_type_id}}">
                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right text-bold">Action Log type:</label>
                            <div class="col-md-8">
                                <select name="user_id" id="user_id" required class="form-control selectize">
                                    <option value="{{(isset($action_log_type)? $action_log_type->user_id: '' )}}" selected >
                                        {{(isset($action_log_type)&&isset($action_log_type->user->name))? $action_log_type->user->name: 'Select Action Log type' }}
                                    </option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{$user->username}}">{{$user->fullName}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($action_log_type) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
