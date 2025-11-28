<div class="panel-body">
    {!! Form::open(['route' => 'tickets.store', 'class' => 'form-horizontal refresh_tickets', 'method' => 'post', 'id' => 'form_' . time()]) !!}
    {{ csrf_field() }}
    {{ Form::hidden('ext', '0') }}
    <div class="form-group row">
        <label for="created_by" style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Created By:') }}</label>
        <div class="col-md-6">
            <input name="created_by" id="created_by" type="text"  class="form-control" value="{{$username}}" placeholder="" readonly required>
        </div>
    </div>
    <div class="form-group row">
        <label for="created_for" class="col-md-4 col-form-label text-md-right text-bold">Created For:</label>
        <div class="col-md-6">
            <select name="created_for" id="created_for" required class="form-control selectize">
                <option value="{{(isset($ticket)? $ticket->created_for: $username )}}" selected >
                    {{(isset($ticket)&&isset($ticket->user->name))? $ticket->user->name: $actual_name }}
                </option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $user)
                        <option value="{{$user['username']}}">{{$user['first_name']}} {{$user['last_name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    {{-- <div class="form-group row">
        <label for="issue_category_id" style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Issue Category:') }}</label>
        <div class="col-md-6">
            <select name="issue_category_id" id="issue_category_id" class="form-control selectize" required>
                <option value="" selected >
                    Select Category
                </option>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="issue_details" style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Issue Details:') }}</label>
        <div class="col-md-6">
            <textarea name="issue_details" id="issue_details" rows="4" type="text" class="form-control" required>{{ (isset($ticket)?$ticket->issue_details:'') }}</textarea>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 col-md-offset-4">
            <button type="button" class="btn btn-primary sendTicket pull-right">Create Ticket</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>