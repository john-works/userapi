<div>
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post" class="form-inline" id="form_{{ time() }}">
                        <div class="row">
                            <label for="request_for" class="col-md-4 col-form-label text-md-right text-bold">Select Employee:</label>
                            <div class="col-md-5">
                                <select name="request_for" id="request_for" required class="form-control selectize">
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm" id="selectEmployee">View Employee</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 hidden" id="employee_view_section" style="margin-top: 2rem">
        <div class="col-md-6">
            <table id="employee_details_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr class="text-center">
                    <th colspan="2">User Profile</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table id="employee_contract_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr class="text-center">
                    <th colspan="2">Contract Information</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row hidden" id="employee_leave_summary" style="margin-top: 1rem">
        <div class="col-md-12">
        <table class="table table-bordered table_annual_leave_summary" style="margin-bottom: 0px;background: #e4e6e9" id="employee_leave_summary_table" >
            <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle">Annual Leave Days (<span id="financial_year"></span>)</th>
                <th>Max</th>
                <th>Approved</th>
                <th>Balance</th>
                <th style="margin-bottom: 0px;background: #ffffff !important"></th>
                <th>Not Submitted/Rejected</th>
                <th>Pending HR Approval</th>
                <th>Pending HOD Approval</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
    <div class="row mt-3 hidden" id="employee_leave_section" style="margin-top: 2rem">
        <div class="col-md-12">
            <table id="employee_leave_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="6">Employee Leave Requests</th>
                    </tr>
                    <tr class="text-center">
                        <th>Leave Type</th>
                        <th>Date Created</th>
                        <th>First Day Out of Office</th>
                        <th>First Back In Office</th>
                        <th>Total Requested Days</th>
                        <th>Approval Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot id="more_leave_records" class="hidden">
                    <tr>
                        <th colspan="5">
                            <button class="clarify_secondary btn btn-primary btn-mini pull-right" id="loadMoreLeave" title="Employee Leave Requests" href="{{ route('leave_requests.more',['USERNAME']) }}">Show More</button>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row mt-3 hidden" id="employee_appraisal_section" style="margin-top: 2rem">
        <div class="col-md-12">
            <table id="employee_appraisal_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="9">Employee Appraisal Requests</th>
                    </tr>
                    <tr class="text-center">
                        <th>Date Created</th>
                        <th>Initiator</th>
                        <th>Type</th>
                        <th>Period Start Date</th>
                        <th>Period End Date</th>
                        <th>Status</th>
                        <th>Current Step</th>
                        <th>Current Step User</th>
                        <th>Current Step Start</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot id="more_appraisal_records" class="hidden">
                    <tr>
                        <th colspan="9">
                            <button class="clarify_secondary btn btn-primary btn-mini pull-right" id="loadMoreAppraisal" title="User Appraisals" href="{{ route('appraisal_requests.more',['USERNAME']) }}">Show More</button>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        populateUserSelect();
        // selectEmployee
        $('body').on('click','#selectEmployee', function(e) {
            e.preventDefault();
            let employee_id = $('#request_for').val();
            var query_limit = 5;
            var user_full_name = $('#request_for option:selected').text();
            if (request_for) {
                load_employee_profile(employee_id);
                load_employee_leave_summary(employee_id);
                load_employee_leave(employee_id,query_limit);
                load_employee_appraisal(employee_id,query_limit);
                load_employee_contracts(employee_id,user_full_name);
                $('#employee_view_section').removeClass('hidden');
            } else {
                alert('Please select an employee');
            }
        });

        function load_employee_profile(employee_id){
            var employee_details_url = "{{ endpoint('get_user_profile') }}"+employee_id;
            $.getJSON( employee_details_url, function( data ) {
                let reponse = data.payload;
                let user = reponse.data;
                if(reponse.statusCode == 0){
                    $('#employee_details_table tbody').empty();
                    var row = '<tr>';
                    row += '<td>Full Name</td>';
                    row += '<td><strong>' + (user.first_name) +' '+ (user.last_name) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Email</td>';
                    row += '<td><strong>' + (user.username) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Employee Start Date</td>';
                    row += '<td><strong>' + (user.employee_start_date) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Employee File Number</td>';
                    row += '<td><strong>' + (user.staff_number) + '</strong></td>';
                    row += '</tr>';
                    $('#employee_details_table tbody').append(row);
                }else{
                    alert(response.statusDescription);
                }
                $('.my-data-overlay').hide();
            }).fail(function(){
                alert('Sorry, we encountered an error while loading the data. Please try again later.');
            });
        }
        function load_employee_leave_summary(employee_id){
            employee_leave_summary_data = [];
            var employee_leave_summary_url = "{{ endpoint('GET_EMPLOYEE_LEAVE_SUMMARY') }}"+employee_id;
            var tableBody = $('#employee_leave_summary_table tbody');
            $.getJSON( employee_leave_summary_url, function( response ) {
                let financialYear = response.data.financialYear;
                let summaryAnnual = response.data.summaryAnnual;
                $('#financial_year').text(financialYear.financial_year);
                tableBody.empty();
                if(response.statusCode == 0){
                        var row = '<tr>';
                        row += '<td></td>';
                        row += '<td>' + (summaryAnnual.maximum_days) + '</td>';
                        row += '<td>' + (summaryAnnual.approved) + '</td>';
                        row += '<td>' + (summaryAnnual.balance) + '</td>';
                        row += '<td style="margin-bottom: 0px;background: #ffffff !important">' + (summaryAnnual.note) + '</td>';
                        row += '<td>' + (summaryAnnual.not_yet_submitted) + '</td>';
                        row += '<td>' + (summaryAnnual.submitted_pending_hr_approval) + '</td>';
                        row += '<td>' + (summaryAnnual.submitted_pending_hod_approval) + '</td>';
                        row += '</tr>';
                        tableBody.append(row);
                    $('#employee_leave_summary').removeClass('hidden');
                }else{
                    alert(data.statusDescription);
                }
                $('.my-data-overlay').hide();
            }).fail(function(){
                alert('Sorry, we encountered an error while loading the data. Please try again later.');
            });
        }
        function load_employee_leave(employee_id,query_limit){
            employee_leave_data = [];
            var employee_leave_url = "{{ endpoint('GET_EMPLOYEE_LEAVE') }}"+employee_id;
            var tableBody = $('#employee_leave_table tbody');
            $.getJSON( employee_leave_url, function( data ) {

                var total_records = data.total_records;
                if(total_records > query_limit){
                    //replace the username in the href with the current username
                    $('#more_leave_records #loadMoreLeave').attr('href', $('#more_leave_records #loadMoreLeave').attr('href').replace('USERNAME', employee_id));
                    $('#more_leave_records').removeClass('hidden');
                }

                if(data.statusCode == 0){
                    tableBody.empty();
                    employee_leave_data = data.data;
                    $.each(employee_leave_data, function(index, item) {
                        if(index >= query_limit){
                            return false;
                        }
                        var row = '<tr>';
                        row += '<td>' + (item.leave_type) + '</td>';
                        row += '<td>' + (item.date_created) + '</td>';
                        row += '<td>' + (item.leave_start_date) + '</td>';
                        row += '<td>' + (item.leave_end_date) + '</td>';
                        row += '<td>' + (item.number_of_days_adjusted) + '</td>';
                        row += '<td>' + (item.approval_status) + '</td>';
                        row += '</tr>';
                        tableBody.append(row);
                    });
                    $('#employee_leave_section').removeClass('hidden');
                }else{
                    alert(data.statusDescription);
                }
                $('.my-data-overlay').hide();
            }).fail(function(){
                alert('Sorry, we encountered an error while loading the data. Please try again later.');
            });
        }
        function load_employee_appraisal(employee_id,query_limit){
            employee_appraisal_data = [];
            var employee_appraisal_url = "{{ endpoint('GET_EMPLOYEE_APPRAISALS') }}"+employee_id;
            var tableBody = $('#employee_appraisal_table tbody');
            $.getJSON( employee_appraisal_url, function( data ) {
                var total_records = data.data.length;
                employee_appraisal_data = data.data;
                tableBody.empty();
                $.each(employee_appraisal_data, function(index, item) {
                    if(index >= query_limit){
                        return false;
                    }
                    item.status = item.status == 'Completed Successfully' ? '<span class="label label-success">Completed Successfully</span>' : '<span class="label label-danger">In Progress</span>';
                    var row = '<tr>';
                    row += '<td>' + (item.date_created) + '</td>';
                    row += '<td>' + (item.owner) + '</td>';
                    row += '<td>' + (item.appraisal_type) + '</td>';
                    row += '<td>' + (formatDate(item.period_start_date)) + '</td>';
                    row += '<td>' + (formatDate(item.period_end_date)) + '</td>';
                    row += '<td>' + (item.status) + '</td>';
                    row += '<td>' + (item.current_step) + '</td>';
                    row += '<td>' + (item.current_step_user) + '</td>';
                    row += '<td>' + (item.current_step_start) + '</td>';
                    row += '</tr>';
                    tableBody.append(row);
                });
                if(total_records > query_limit){
                    $('#more_appraisal_records #loadMoreAppraisal').attr('href', $('#more_appraisal_records #loadMoreAppraisal').attr('href').replace('USERNAME', employee_id));
                    $('#more_appraisal_records').removeClass('hidden');
                }
                $('#employee_appraisal_section').removeClass('hidden');
                $('.my-data-overlay').hide();
            }).fail(function(){
                alert('Sorry, we encountered an error while loading the data. Please try again later.');
            });
        }

        function load_employee_contracts(employee_id,user_full_name){
            employee_contract_data = [];
            var employee_contract_url = "{{ endpoint('GET_EMPLOYEE_CONTRACTS') }}"+employee_id;
            var tableBody = $('#employee_contract_table tbody');
            $.getJSON( employee_contract_url, function( response ) {
                var contract_array = response.data;
                var contract = contract_array[0];
                if(contract_array.length > 0){
                    $('#employee_contract_table tbody').empty();
                    var row = '<tr>';
                    row += '<td>Full Name</td>';
                    row += '<td><strong>' + user_full_name + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Contract Start Date</td>';
                    row += '<td><strong>' + (contract.start_date) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Contract End Date</td>';
                    row += '<td><strong>' + (contract.expiry_date) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Created By</td>';
                    row += '<td><strong>' + (contract.created_by) + '</strong></td>';
                    row += '</tr>';
                    row += '<tr>';
                    row += '<td>Date Created</td>';
                    row += '<td><strong>' + (contract.created_at) + '</strong></td>';
                    row += '</tr>';
                    $('#employee_contract_table tbody').append(row);
                }else{
                    console.error('No user contract found');
                    // alert(response.statusCode);
                }
                $('.my-data-overlay').hide();
            }).fail(function(){
                alert('Sorry, we encountered an error while loading the data. Please try again later.');
            });
        }
        function populateUserSelect() {
            $('#request_for').empty();
            let current_users = JSON.parse(localStorage.getItem('active_users'));
            if (current_users && current_users.payload && current_users.payload.data) {
                let users = current_users.payload.data;
                $('#request_for').append(`<option value="" selected> Select Employee</option>`);
                $.each(users, function(index, user) {
                    let fullName = user.first_name + " " + user.last_name;
                    $('#request_for').append(`<option value="${user.username}">${fullName}</option>`);
                });
            } else {
                console.error('No active users found');
            }
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const formattedDate = date.toLocaleDateString("en-US", {
                month: "short",
                day: "2-digit",
                year: "numeric"
            });
            return formattedDate.replace(/,/g, '');
        }

    });
</script>
