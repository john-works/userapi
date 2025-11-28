<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{route('trusted-devices.save')}}" class="form-horizontal custom_response set_trust_device" id="{{'form_'.time()}}">

                        <input type="hidden" name="username" value="{{$authUser->username}}"/>
                        <input type="hidden" name="device_ip" value="{{$deviceIp}}"/>
                        <input type="hidden" name="browser" value="{{$browser}}"/>
                        <input type="hidden" name="other_device_details" value="{{$otherDeviceData}}"/>
                        {{csrf_field()}}

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right"></label>
                            <div class="col-md-6 font-bold">
                                Are you sure you want to set the Device with Details below as your Trusted Device?
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">User Name:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{$authUser->fullName}}" readonly />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Browser:</label>
                            <div class="col-md-6">
                                <input id="utd_browser" type="text" class="form-control" value="{{$browser}}" readonly />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Device IP:</label>
                            <div class="col-md-6">
                                <input id="utd_device_ip"  type="text" class="form-control" value="{{$deviceIp}}" readonly />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Device Name:</label>
                            <div class="col-md-6">
                                <input id="utd_device_name" type="text" name="device_name" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group row show-on-code-sent hide">
                            <label class="col-md-4 col-form-label font-bold text-md-right"></label>
                            <div class="col-md-6">
                                A confirmation code has been sent to your email please enter the code below to proceed.
                            </div>
                        </div>

                        <div class="form-group row show-on-code-sent hide">
                            <label class="col-md-4 col-form-label font-bold text-md-right">Confirmation Code:</label>
                            <div class="col-md-6">
                                <input type="text" name="confirmation_code_input" id="confirmation_code_input" class="form-control"  />
                            </div>
                            <input type="hidden" name="confirmation_code" value="confirmation_code" id="confirmation_code"/>
                        </div>

                        <div class="form-group row mb-0 hide-on-code-sent">
                            <div class="col-md-6 col-md-offset-4">
                                <a data-url="{{route('trusted-devices.send-confirmation-code',['PARAM_DETAILS'])}}" href="#" class="btn btn-primary btnTrustedDeviceVerificationCode">Confirm</a>
                            </div>
                        </div>

                        <div class="form-group row mb-0 show-on-code-sent hide">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary btnSubmit" value="{{(isset($record)?"Update":"Verify & Save Device")}}"/>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

