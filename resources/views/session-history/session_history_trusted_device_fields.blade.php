<div class="form-group row">
    <label for="device_id"  style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Username:') }}</label>
    <div class="col-md-6">
        <input id="device_id" type="text" class="form-control" readonly value="{{$username}}">
    </div>
</div>

<div class="form-group row">
    <label for="device_id"  style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Device ID:') }}</label>
    <div class="col-md-6">
        <input id="device_id" type="text" class="form-control" readonly value="{{$deviceId}}">
    </div>
</div>

<div class="form-group row">
    <label for="deviceName"  style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Device Name:') }}</label>
    <div class="col-md-6">
        <input id="deviceName" type="text" class="form-control" readonly value="{{$deviceName}}">
    </div>
</div>

<div class="form-group row">
    <label for="browser"  style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Browser:') }}</label>
    <div class="col-md-6">
        <input id="browser" type="text" class="form-control" readonly value="{{$browser}}">
    </div>
</div>

<div class="form-group row">
    <label for="dateTimeCreated"  style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Date Created:') }}</label>
    <div class="col-md-6">
        <input id="dateTimeCreated" type="text" class="form-control" readonly value="{{get_user_friendly_date_time($dateTimeCreated)}}">
    </div>
</div>