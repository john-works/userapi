    <div class="row">
            <div class="table">
                <table id="employee_leaves_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>Leave Type</th>
                            <th>First Day Out of Office</th>
                            <th>First Back In Office</th>
                            <th>Approval Status</th>
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
            var url = "{{endpoint('GET_EMPLOYEE_LEAVE_DETAILS')}}"+username;
            $.getJSON(url, function( response ) {
                var data = response.data;
                $.each(data, function( key, value ) {
                    var row = "<tr>";
                    row += "<td>"+value.leave_type+"</td>";
                    row += "<td>"+value.leave_start_date+"</td>";
                    row += "<td>"+value.leave_end_date+"</td>";
                    row += "<td>"+value.approval_status+"</td>";
                    row += "</tr>";
                    $('#employee_leaves_table tbody').append(row);
                });
            });
        });
    </script>