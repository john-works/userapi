<div class="row py-5">
    @unless($actionlog->status == ACTION_LOG_STATUS_CLOSED)
    <div class="col-md-6 mx-auto">
            <table class="table bg-info">
                <tr>
                    <td>Date Opened</td>
                    <td><strong>{{$actionlog->date_opened}} </strong>  By: {{$actionlog->created_by}}</td>
                </tr>
                <tr>
                    <td>Reference Number</td>
                    <td><strong>{{$actionlog->reference_number}}</strong></td>
                </tr>
                <tr>
                    <td>Required Action</td>
                    <td><strong>{{$actionlog->required_action}}</strong></td>
                
                </tr>
            </table>

    </div>
</div>
<div class="row">
    <div class="col-md-12" id="action_log_panel">
        <h4 class="panel-title" >
            <a class="accordion-toggle " data-parent="#accordion_ad_review" href="#!"
                aria-expanded="false">Status</a>
        </h4>  
    </div>
    <br />

    <div class="col-md-12">
        <a class="btn btn-primary btn-sm justify-center clarify_tertiary pull-right" title="Add Action Log Status" href="{{ route('statusupdates.create',$actionlog->id) }}">Add New Status</a>
    </div>
    <br />
</div>
@endunless

    <div class="row bg-white">
        <div class="col-md-12 data-table-simple datatable-no-length datatable-no-info datatable-no-search datatable-no-paginate datatable-no-resultcount">
            <table class="data-table status_update_details {{$actionlog->id}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide_first_column" id="status_update_details" >
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Current Status Update</th>
                    <th>Created By</th>
                    <th>Date Created</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <br />
    
    <div class="row">
        <div class="col-md-12" id="action_log_panel">
            <h4 class="panel-title" >
                <a class="accordion-toggle " data-parent="#accordion_ad_review" href="#!"
                    aria-expanded="false">Tasks</a>
            </h4>  
        </div>
        <br />
    
        <div class="col-md-12">
            <a class="btn btn-primary btn-sm justify-center clarify_tertiary pull-right" title="Add New Task" href="{{ route('statusupdates.create_task',$actionlog->id) }}">Add New Task</a>
        </div>
        <br />
    </div>
    <div class="row bg-white">
        <div class="col-md-12 data-table-simple datatable-no-length datatable-no-info datatable-no-search datatable-no-paginate datatable-no-resultcount">
            <table class="data-table action_log_tasks {{$actionlog->id}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide_first_column" id="action_log_tasks" >
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Task User</th>
                    <th>Task Details</th>
                    <th>Planned Completion Date</th>
                    <th>Created By</th>
                    <th>Date Updated</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>