<!DOCTYPE html>
<html>
    <head>
        <title>IT Tickets</title>
    </head>
    <body>
        <div class="form-actions no-margin-bottom">
            <div class="float-alert center">
                <div class="float-alert-container">
                    <div class="col-md-12">
                        <button href="{{ route('tickets.create',[$username]) }}" class="clarify_secondary btn btn-primary btn-sm" title="Add Ticket">Add Ticket</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="p-5- body-load" style="display: none;">
            <table id="tickets_table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Created Date</th>
                        <th>Created By</th>
                        <th>Created For</th>
                        <th>Issue Details</th>
                        <th>Status</th>
                        <th>Planned Completion Date</th>
                        <th>Actions</th>
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
            var tickets_data = []
            var dt_tickets

            $(document).ready(function() {

                var url = "{{ route('trusted-devices.ajax') }}";
                var server_error_msg = '<div class="alert alert-danger">ERROR: There is no Trusted Device found!!</div>';
                var financial_years, entities
                $.get(url,function(data){
                    //console.log(data)
                    if(/Valid Cookie Approved/.test(data)){ 
                        $('.server-data-overlay').hide()
                        $('.body-load').show()

                        var jsonData = JSON.parse(data)
                        device = jsonData.trustedDevice
                        user = device.username
                        load_tickets();

                    }else{
                        $('.server-data-overlay .overlay-message').html(server_error_msg)
                    }
                }).fail(function() {
                    $('.server-data-overlay .overlay-message').html(server_error_msg)
                })

                function load_tickets(){
                    tickets_data = [];
                    dt_tickets = $('#tickets_table').DataTable({
                            'searching':true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':tickets_data,
                            'order': [[0, 'desc']],
                            'columns':[
                                {data:'created_at'},
                                {data:'created_by'},
                                {data:'created_for'},
                                {data:'issue_details'},
                                {data:'status'},
                                {data:'planned_completion_date'},
                                {
                                    data: null,
                                    render: function (data, type, row) {
                                        if (row.status === 'Closed') {
                                            return `<button id="${row.id}" class="btn btn-sm btn-primary reopenTicket">Reopen</button>`;
                                        } else {
                                            return '';
                                        }
                                    },
                                    orderable: false,
                                    searchable: false
                                }

                            ],
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'IT Tickets'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'IT Tickets'
                                }
                            ],
                            "language": {
                                "emptyTable": "No IT Tickets found!!"
                            }
                        });
                    fetch_stores_tickets();
                }

                function fetch_stores_tickets(){
                    var tickets_url = "{{ endpoint('STORES_GET_TICKETS') }}"+user;
                    $.getJSON( tickets_url, function( data ) {
                        if(data.statusCode == 0){
                            tickets_data = data.data;
                            dt_tickets.rows.add(tickets_data).draw();
                        }else{
                            console.log(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }
                $('body').on('click', '.sendTicket', function (e) {
                    e.preventDefault();
                    var url = $(this).parents('form').attr('action');
                    var form_id = $(this).parents('form').attr('id');
                    if(!validate_form(form_id)){
                        return false
                    }
                    var created_by = $('#created_by').val();
                    var created_for = $('#created_for').val();
                    var issue_category_id = $('#issue_category_id').val();
                    var issue_details = $('#issue_details').val();
                    var data = {
                        created_by: created_by,
                        created_for: created_for,
                        issue_details: issue_details
                    }
                    $.ajax({
                        url: "{{ endpoint('STORES_CREATE_TICKET') }}",
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            if (response.success == true) {
                                $('#tickets_table').DataTable().clear().destroy();
                                load_tickets();
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

                $('#tickets_table').on('click', '.reopenTicket', function(e){
                    e.preventDefault();
                    var ticket_id = $(this).attr('id');
                    var ticket_created_by = $(this).closest('tr').find('td:eq(1)').text();
                    var ticket_created_for = $(this).closest('tr').find('td:eq(2)').text();
                    var url = "{{ route('tickets.reopen') }}";
                    //make ajax call to reopen ticket
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            ticket_id: ticket_id,
                            ticket_created_by: ticket_created_by,
                            ticket_created_for: ticket_created_for
                        },
                        success: function(data){
                            $('.bs-fill-modal' +' .modal-title').html('Reopen Ticket');
                            $('.bs-fill-modal' +' .modal-body').html(data);
                            $('.bs-fill-modal').modal('show');
                        },
                        error: function(){
                            alert('Sorry, we encountered an error while reopening the ticket. Please try again later.');
                        }
                    });
                    
                });
                $('body').on('click', '.reopenTicketStatus', function(e){
                    e.preventDefault();
                    var url = $(this).parents('form').attr('action');
                    var form_id = $(this).parents('form').attr('id');
                    if(!validate_form(form_id)){
                        return false
                    }
                    var ticket_id = $('#ticket_id').val();
                    var created_by = $('#created_by').val();
                    var created_for = $('#created_for').val();
                    var issue_details = $('#issue_details').val();
                    var data = {
                        ticket_id: ticket_id,
                        created_by: created_by,
                        created_for: created_for,
                        issue_details: issue_details
                    }
                    $.ajax({
                        url: "{{ endpoint('STORES_REOPEN_TICKET') }}",
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            if (response.success == true) {
                                $('#tickets_table').DataTable().clear().destroy();
                                load_tickets();
                                $('#'+form_id).closest('.modal').modal('hide');
                                show_custom_message_modal('success', response.message, null, null);
                            } else {
                                show_custom_message_modal('error', response.message, null, null);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                });
            } );
        </script>
    </body>
</html>
