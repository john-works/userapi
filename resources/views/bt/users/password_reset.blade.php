<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{route('user.reset-password')}}" class="form-horizontal custom_response" id="{{'form_'.time()}}">

                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4" style="color: #757575 !important;margin-bottom: 10px">You can reset your password</div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Username:</label>
                            <div class="col-md-6">
                                <input type="text" name="username" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary btnSubmit" value="{{(isset($record)?"Update":"Reset Password")}}"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
