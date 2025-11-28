<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{route('trusted-devices.admin.revoke-user.save')}}" class="form-horizontal custom_response" id="{{'form_'.time()}}">

                        {{csrf_field()}}

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-bold text-md-right">User to Revoke</label>
                            <div class="col-md-9">
                                <select name="username" required class="form-control chosen-select">
                                    <option value="" disabled selected>Select User</option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{$user->username}}">{{$user->first_name.' '.$user->last_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 col-md-offset-3">
                                <input type="submit" class="btn btn-primary btnSubmit" value="{{(isset($record)?"Update":"Revoke Trusted Devices")}}"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

