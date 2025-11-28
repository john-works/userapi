<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top" id="pending-actions-table">
            <thead>
                <tr>
                    <th>Application</th>
                    <th>Task Details</th>
                    <th>Current Step</th>
                    <th>Next Action User</th>
                    <th>Start Date</th>
                    <th>Duration</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    var dataSet = [];
    var dt_pending_actions = $('#pending-actions-table').DataTable({
        'searching':true,
        'lengthMenu': [[100, -1], [100, "All"]],
        'data':dataSet,
        'buttons': [
            {
                extend: 'pdf',
                text: 'Export to PDF',
                title: 'My Pending Actions'
            },
            {
                extend: 'csv',
                text: 'Export to Excel',
                title: 'My Pending Actions'
            }
        ],
        "language": {
            "emptyTable": "No Pending Actions found!!"
        }
    });

    fetch_emis_pending_actions();
    fetch_appraisal_pending_actions();
    fetch_actionlog_pending_actions();
    fetch_stores_pending_actions();
    fetch_fleet_pending_actions();

    function fetch_emis_pending_actions(){
        var requisition_action_url = "{{ endpoint('EMIS_GET_PENDING_ACTIONS').$user }}"
        $.getJSON( requisition_action_url, function( data ) {
            if(data.statusCode == 0){
                dataSet = data.data;
                dt_pending_actions.rows.add(dataSet).draw();
            }else{
                bootbox.alert(data.statusDescription);
            }
            $('.my-data-overlay').hide();
        }).fail(function(){
            alert('Sorry, we encountered an error while loading the data. Please try again later.');
        });
    }

    function fetch_appraisal_pending_actions(){
        var appraisal_action_url = "{{ endpoint('APPRAISAL_GET_PENDING_ACTIONS').$user }}"
        $.getJSON( appraisal_action_url, function( data ) {
            console.log(data);
            if(data.statusCode == 0){
                dataSet = data.data;
                dt_pending_actions.rows.add(dataSet).draw();
            }else{
                bootbox.alert(data.statusDescription);
            }
            $('.my-data-overlay').hide();
        }).fail(function(){
            alert('Sorry, we encountered an error while loading the data. Please try again later.');
        });
    }
    function fetch_actionlog_pending_actions(){
        var requisition_action_url = "{{ endpoint('ACTIONLOG_GET_PENDING_ACTIONS').$user }}"
        
        $.getJSON( requisition_action_url, function( data ) {
            if(data.statusCode == 0){
                dataSet = data.data;
                dt_pending_actions.rows.add(dataSet).draw();
            }else{
                bootbox.alert(data.statusDescription);
            }
            $('.my-data-overlay').hide();
        }).fail(function(){
            alert('Sorry, we encountered an error while loading the data. Please try again later.');
        });
    }

    function fetch_stores_pending_actions(){
        var stores_action_url = "{{ endpoint('STORES_GET_PENDING_ACTIONS').$user }}"
        
        $.getJSON( stores_action_url, function( data ) {
            if(data.statusCode == 0){
                dataSet = data.data;
                dt_pending_actions.rows.add(dataSet).draw();
            }else{
                bootbox.alert(data.statusDescription);
            }
            $('.my-data-overlay').hide();
        }).fail(function(){
            alert('Sorry, we encountered an error while loading the data. Please try again later.');
        });
    }
    
    function fetch_fleet_pending_actions(){
        var fleet_action_url = "{{ endpoint('FLEET_GET_PENDING_ACTIONS').$user }}"
        
        $.getJSON( fleet_action_url, function( data ) {
            if(data.statusCode == 0){
                dataSet = data.data;
                dt_pending_actions.rows.add(dataSet).draw();
            }else{
                bootbox.alert(data.statusDescription);
            }
            $('.my-data-overlay').hide();
        }).fail(function(){
            alert('Sorry, we encountered an error while loading the data. Please try again later.');
        });
    }
</script>