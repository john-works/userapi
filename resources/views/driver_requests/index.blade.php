<!DOCTYPE html>
<html>
    <head>
        <title>Driver Requests</title>
    </head>
    <body>
        <div class="alert alert-danger">
            <strong>The quick driver request is only for same day town running requests. Long distance activities should be submitted in FMS</strong>
        </div> 
        <div class="form-actions no-margin-bottom">
            <div class="float-alert center">
                <div class="float-alert-container">
                    <div class="col-md-12">
                        <button href="{{ route('driver_requests.create',[$username]) }}" class="clarify_secondary btn btn-primary btn-sm" id="create_driver_request" title="Add Driver Request">Add Driver Request</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="p-5- body-load" style="display: none;">
            <table id="driver_requests_table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Request By</th>
                        <th>Destination</th>
                        <th>Drop Off Date</th>
                        <th>Pick Up Date</th>
                        <th>Driver</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="server-data-overlay">
            <div class="overlay-message">
                Please wait as we fetch data from the server!!!
            </div>
        </div>

        <div class="my-data-overlay" style="display: none;">
            <div class="overlay-message">
                Please wait as we fetch results!!!
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            var server = "{{endpoint('api_router')}}";
            var device = null
            var user = null
            var dataSet = {}
            var driver_requests_data = []
            var dt_driver_requests

            $(document).ready(function() {

                var url = "{{ route('trusted-devices.ajax') }}";
                var server_error_msg = '<div class="alert alert-danger">ERROR: There is no Trusted Device found!!</div>';
                var financial_years, entities
                $.get(url,function(data){
                    if(/Valid Cookie Approved/.test(data)){ 
                        $('.server-data-overlay').hide()
                        $('.body-load').show()

                        var jsonData = JSON.parse(data)
                        device = jsonData.trustedDevice
                        user = device.username
                        load_driver_requests();

                    }else{
                        $('.server-data-overlay .overlay-message').html(server_error_msg)
                    }
                }).fail(function() {
                    $('.server-data-overlay .overlay-message').html(server_error_msg)
                })

                function load_driver_requests(){
                    driver_requests_data = [];
                    dt_driver_requests = $('#driver_requests_table').DataTable({
                            'searching':true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':driver_requests_data,
                            'order': [[0, 'desc']],
                            'columns':[
                                {data:'request_date'},
                                {data:'created_by'},
                                {data:'destination'},
                                {data:'drop_off_date'},
                                {data:'pick_up_date'},
                                {data:'driver'}
                            ],
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'Driver requests'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'Driver requests'
                                }
                            ],
                            "language": {
                                "emptyTable": "No Driver requests found!!"
                            }
                        });
                    fetch_fleet_driver_requests();
                }

                function fetch_fleet_driver_requests(){
                    var driver_requests_url = "{{ endpoint('FLEET_GET_DRIVER_REQUESTS') }}"+user;
                    $.getJSON( driver_requests_url, function( data ) {
                        if(data.statusCode == 0){
                            driver_requests_data = data.data;
                            dt_driver_requests.rows.add(driver_requests_data).draw();
                        }else{
                            console.log(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                $('body').on('click', '.sendDriverRequest', function (e) {
                    e.preventDefault();
                    var url = $(this).parents('form').attr('action');
                    var form_id = $(this).parents('form').attr('id');
                    if(!validate_form(form_id)){
                        return false
                    }
                    var request_by = $('#request_by').val();
                    var request_for = $('#request_for').val();
                    var request_date = $('#request_date').val();
                    var destination = $('#destination').val();
                    var drop_off_date = $('#drop_off_date').val();
                    var pick_up_date = $('#pick_up_date').val();
                    var drop_off_time = $('#drop_off_time').val();
                    var pick_up_time = $('#pick_up_time').val();

                    var data = {
                        request_by: request_by,
                        request_for: request_for,
                        request_date: request_date,
                        destination: destination,
                        drop_off_date: drop_off_date,
                        pick_up_date: pick_up_date,
                        drop_off_time: drop_off_time,
                        pick_up_time: pick_up_time
                    }
                    $.ajax({
                        url: "{{ endpoint('FLEET_CREATE_DRIVER_REQUEST') }}",
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if (response.success == true) {
                                $('#driver_requests_table').DataTable().clear().destroy();
                                load_driver_requests();
                                $('#'+form_id).closest('.modal').modal('hide');

                            } else {
                                show_custom_message_modal('error', response.message, null, null);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                })
            } );
        </script>
    </body>
</html>
