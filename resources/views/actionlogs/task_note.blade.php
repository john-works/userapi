<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('action_log_tasks.close') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        @if(isset($action_log_task))
                            <input type="hidden" name="id" value="{{ $action_log_task->id }}">
                            <input type="hidden" name="completion_user" value="{{ session('user')->username }}">
                        @endif
                        <div class="form-group row">
                            <label for="completion_note" class="col-md-4 col-form-label text-md-right text-bold">Completion Note:</label>
                            <div class="col-md-8">
                                <textarea type="text" name="completion_note"  class="form-control" id="completion_note" rows="3" required>{{ isset($action_log_task) ? $action_log_task->completion_note : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($action_log_task) ? 'Close' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
