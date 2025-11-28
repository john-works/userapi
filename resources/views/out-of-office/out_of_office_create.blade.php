<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body out_of_office">

                    <form method="post" action="{{route('out-of-office.store')}}" class="form-horizontal custom_response" id="{{'form_'.time()}}">

                        {{-- if $enableUserSelection is set and $enableUserSelection ==  1, we show a dropdown of users else it's the authenticated user--}}
                        <input type="hidden" name="added_by_user" value="{{$username}}"/>
                        {{csrf_field()}}
                        @if(isset($enableUserSelection) && $enableUserSelection ==1)

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-bold text-md-right">Added By:</label>
                                <div class="col-md-9">
                                    <input name="added_by_user" class="form-control" value="{{getAuthUser()->fullName}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-bold text-md-right">On Behalf of User:</label>
                                <div class="col-md-9">
                                    <select name="delegation_by" required class="form-control chosen-select">
                                        <option value="" disabled selected>Select User</option>
                                        @if(isset($users) && count($users) > 0)
                                            @foreach($users as $user)
                                                @if($user->username != $username)
                                                <option value="{{$user->username}}">{{$user->first_name.' '.$user->last_name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="delegation_by" value="{{$username}}"/>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-bold text-md-right">Delegation To:</label>
                            <div class="col-md-9">
                                <select name="delegation_to" required class="form-control chosen-select">
                                    <option value="" disabled selected>Select User</option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{$user->username}}">{{$user->first_name.' '.$user->last_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-bold text-md-right">Start Date:</label>
                            <div class="col-md-4">
                                <input name="start_date" type="date" class="form-control" required/>
                            </div>
                            <label class="col-md-3 col-form-label font-bold text-md-right">Time:</label>
                            <div class="col-md-2">
                                <input name="start_time" type="time" class="browser-default" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-bold text-md-right">End Date:</label>
                            <div class="col-md-4">
                                <input name="end_date" type="date" class="form-control" required/>
                            </div>
                            <label class="col-md-3 col-form-label font-bold text-md-right">Time:</label>
                            <div class="col-md-2">
                                <input name="end_time" type="time" class="browser-default" required/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 col-md-offset-3">
                                <input type="submit" class="btn btn-primary btnSubmit" value="{{(isset($record)?"Update":"Save out of Office")}}"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

