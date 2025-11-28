<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('calendar_type_admins.store') }}" method="post" class="form-horizontal custom_reponse" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($calendar_type_admin) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($calendar_type_admin))
                            <input type="hidden" name="id" value="{{ $calendar_type_admin->id }}">
                        @endif
                        <input type="hidden" name="calendar_type_id" value="{{ $calendar_type->id }}"> {{-- <input type="hidden" name="calendar_type_id" value="{{$department_id}}"> --}}
                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right text-bold">Calendar Type Admin:</label>
                            <div class="col-md-8">
                                <select name="user_id" id="user_id" required class="form-control selectize">
                                    <option value="{{(isset($calendar_type_admin)? $calendar_type_admin->user_id: '' )}}" selected >
                                        {{(isset($calendar_type_admin)&&isset($calendar_type_admin->user->name))? $calendar_type_admin->user->name: 'Select Calendar Type Admin' }}
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
                                    {{ isset($calendar_type_admin) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
