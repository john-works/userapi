<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('board_committees.store') }}" method="post" class="form-horizontal response_with_id" id="form_{{ time() }}">
                        {{@csrf_field()}}
                        <input type="hidden" name="{{ isset($board_committee) ? 'updated_by' : 'created_by' }}" value="{{ session('user')->username }}">
                        @if(isset($board_committee))
                            <input type="hidden" name="id" value="{{ $board_committee->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-bold">Board committee Name:</label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" value="{{ isset($board_committee) ? $board_committee->name : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnSubmit" data-next="{{route('board_committees.edit','[ID]')}}">
                                    {{ isset($board_committee) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
