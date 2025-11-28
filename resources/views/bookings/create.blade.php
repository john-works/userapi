<form action="{{route('bookings.store')}}" class="response_with_id" method="post" id="form_{{time()}}">
    @csrf
        @if(isset($booking))
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        @endif
        <input type="hidden" id="requested_by" name="requested_by"value="{{ (isset($booking)?$booking->request_by:session('user')->username) }}" required>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="purpose">Purpose</label>
                <input type="text" class="form-control" id="purpose" name="purpose" value="{{ isset($booking) ? $booking->purpose : '' }}" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="start">Start</label>
                <input type="datetime-local" class="form-control" id="start" name="start" value="{{ isset($booking) ? $booking->start : '' }}" required>
            </div>
            <div class="col-md-6">
                <label for="end">End</label>
                <input type="datetime-local" class="form-control" id="end" name="end" value="{{ isset($booking) ? $booking->end : '' }}" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="internal_participants">Internal Participants</label>
                <input type="number" class="form-control" id="internal_participants" name="internal_participants" value="{{ isset($booking) ? $booking->internal_participants : '' }}" required>
            </div>
            <div class="col-md-6">
                <label for="external_participants">External Participants</label>
                <input type="number" class="form-control" id="external_participants" name="external_participants" value="{{ isset($booking) ? $booking->external_participants : '' }}" required>
            </div>
        </div>
        <div class="form-group row">
            @foreach ($resources as $resource)
                <div class="form-check">
                    <input class="form-check-input" name="shared_resources[]" type="checkbox" value="{{ $resource->id }}" id="resource_{{ $resource->id }}">
                    <label class="form-check-label" for="resource_{{ $resource->id }}">
                        {{ $resource->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-group row">
            <div class="text-center col-md-12">
                <input type="submit" value="{{isset($booking)?'Update':'Save'}}" class="btn btn-primary btnSubmit" data-next="{{route('bookings.edit','[ID]')}}">
            </div>
        </div>
</form>