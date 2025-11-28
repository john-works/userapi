<div class="form-actions no-margin-bottom">
<div class="float-alert center">
    <div class="float-alert-container">
        <div class="col-md-12">
            <a href="{{ route('action_log_types.create',$action_log_type->id) }}" class="clarify_secondary btn btn-primary btn-sm" title="Add Action Log Admins">
                Add Action Log Admins
            </a>
            <hr>
        </div>
    </div>
</div>

<div class="clearfix"></div>
</div>
<table class="data-table action_log_type_admins {{$action_log_type->id}} table table-striped table-bordered table-hover no-margin-bottom no-border-top">
    <thead>
        <tr>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>


