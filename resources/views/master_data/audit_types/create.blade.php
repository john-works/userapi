<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('audit_types.store') }}" method="post" class="form-horizontal custom_reponse" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($auditType) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($auditType))
                            <input type="hidden" name="id" value="{{ $auditType->id }}">
                        @endif

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right text-bold">Name:</label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" value="{{(isset($auditType)? $auditType->name:'')}}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($auditType) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
