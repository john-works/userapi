<div class="row">
    <div class="table">
        <table id="employee_appraisal_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
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
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var username = "{{$username}}";
        var url = "{{endpoint('GET_EMPLOYEE_APPRAISALS')}}"+username;
        $.getJSON(url, function( response ) {
            var employee_appraisal_data = response.data;
            $.each(employee_appraisal_data, function(index, item) {
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
                $('#employee_appraisal_table tbody').append(row);
            });
        });

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