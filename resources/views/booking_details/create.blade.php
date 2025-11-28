<form action="{{route('booking_details.store')}}" class="custom_response" method="post" id="form_{{time()}}">
    @csrf
    
    <div class="form-group mb-0">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary btnSubmit">
                {{ isset($statusupdate) ? 'Update' : 'Save' }}
            </button>
        </div>
    </div>
</form>