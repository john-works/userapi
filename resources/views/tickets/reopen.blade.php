<div class="panel-body">
    {!! Form::open(['route' => 'ticket_reopens.store', 'class' => 'form-horizontal refresh_tickets', 'method' => 'post', 'id' => 'form_' . time()]) !!}
    {{ csrf_field() }}
    {{ Form::hidden('ext', '0') }}
    <input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket_id}}">
    <div class="form-group row">
        <label for="created_by" style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Created By:') }}</label>
        <div class="col-md-6">
            <input name="created_by" id="created_by" type="text"  class="form-control" value="{{$created_by}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="created_for" class="col-md-4 col-form-label text-md-right text-bold">Created For:</label>
        <div class="col-md-6">
            <input name="created_for" id="created_for" type="text"  class="form-control" value="{{$created_for}}"  readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="issue_details" style="font-weight: bold" class="col-md-4 col-form-label text-md-right">{{ __('Issue Details:') }}</label>
        <div class="col-md-6">
            <textarea name="issue_details" id="issue_details" rows="4" type="text" class="form-control" required></textarea>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 col-md-offset-4">
            <button type="button" class="btn btn-primary reopenTicketStatus pull-right">Reopen Ticket</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>