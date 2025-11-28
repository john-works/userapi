<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{route('change_password')}}" class="form-horizontal custom_response" id="{{'form_'.time()}}">

                        <input type="hidden" name="username" class="form-control" value="{{session('user')->username}}" />
                        {{csrf_field()}}

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Old Password:</label>
                            <div class="col-md-6">
                                <input type="password" name="old_password" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">New Password:</label>
                            <div class="col-md-6">
                                <input type="password" name="new_password" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Confirm New Password:</label>
                            <div class="col-md-6">
                                <input type="password" name="new_password_confirmation" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary btnSubmit" value="{{(isset($record)?"Update":"Change Password")}}"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
