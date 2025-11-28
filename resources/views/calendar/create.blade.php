<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('calendars.store') }}" method="post" class="form-horizontal response_with_id" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($calendar) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($calendar))
                            <input type="hidden" name="id" value="{{ $calendar->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-bold">Calendar Name:</label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" value="{{ isset($calendar) ? $calendar->name : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-md-4 col-form-label text-md-right text-bold">Text Color:</label>
                            <div class="col-md-8">
                                <input type="color" name="color" id="color" class="form-control" value="{{ isset($calendar) ? $calendar->color : '#ffffff' }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-md-4 col-form-label text-md-right text-bold">Background Color:</label>
                            <div class="col-md-8">
                                <input type="color" name="background_color" id="background_color" class="form-control" value="{{ isset($calendar) ? $calendar->backgroundColor : '#0000ff' }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($calendar) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
