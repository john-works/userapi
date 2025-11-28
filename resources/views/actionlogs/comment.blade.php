<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('actionlogs.close') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        @if(isset($actionlog))
                            <input type="hidden" name="id" value="{{ $actionlog->id }}">
                            <input type="hidden" name="completion_user" value="{{ session('user')->username }}">
                        @endif
                        <div class="form-group row">
                            <label for="completion_comment" class="col-md-4 col-form-label text-md-right text-bold">Completion Comment:</label>
                            <div class="col-md-8">
                                <textarea type="text" name="completion_comment"  class="form-control" id="completion_comment" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($actionlog) ? 'Close' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
