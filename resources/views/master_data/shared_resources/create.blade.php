<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shared_resources.store') }}" method="post" class="form-horizontal custom_reponse" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($shared_resource) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($shared_resource))
                            <input type="hidden" name="id" value="{{ $shared_resource->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-6 col-form-label text-md-right text-bold">Name:</label>
                            <div class="col-md-6">
                                <input type="text" name="name" id="name" class="form-control" value="{{ isset($shared_resource) ? $shared_resource->name : '' }}" required>
                            </div>
                        </div>
                        {{-- location --}}
                        <div class="form-group row">
                            <label for="location" class="col-md-6 col-form-label text-md-right text-bold">Location:</label>
                            <div class="col-md-6">
                                <input type="text" name="location" id="location" class="form-control" value="{{ isset($shared_resource) ? $shared_resource->location : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-6">
                                <button type="submit" class="btn btn-primary btnSubmit">
                                    {{ isset($shared_resource) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
