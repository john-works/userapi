<!DOCTYPE html>
<html>
    <head>
        <title>ED Dashboard</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

        <style>

            .my-data-overlay,.server-data-overlay{
                position: fixed;
                z-index: 900;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,.5);
            }
            .overlay-message {
                width: 200px;
                margin: 20% auto auto auto;
                text-align: center;
                background: #fff;
                padding: 20px;
            }
            .server-data-overlay .overlay-message{
                width: 500px;
                margin-top: 20%;
            }

            .body-load{
                font-size: 13px !important;
                font-family: "Roboto", Arial, Tahoma, sans-serif;
                margin-top: 20px;
            }
            .body-load ul{
                list-style: none !important;
                margin-left: 0 !important
            }
            .body-load input[type="text"], .body-load .form-control{
                /* font-size: 1rem !important; */
                font-size: 13px !important;
            }
            .body-load .btn{
                font-size: 13px !important;
            }
            input[type="submit"].submit{
                font-size: 13px !important;
            }
            /* .body-load .nav-pills .nav-link {
                box-shadow: 0 10px 15px -3px #0000001a,0 4px 6px -2px #0000000d!important;
                border: none;
                margin: auto 8px;
                background-color: #ffffff;
                font-weight: bold;
                font-size: 11px;
            }
            .body-load .nav-pills > .nav-item:last-child .nav-link{
                margin-right: 0;
            } */

            .dt-buttons{
                float: right !important;
            }
            .dt-buttons button{
                background: #fb9191 !important;
            }
            .body-load .dataTable thead,.body-load .dataTable thead th{
                background: #8ce2ff !important;
            }

            .btn-select{
                padding: 0px 10px;
            }

            .btn-select,.btn-search-x{
                width: 100px;
            }

            table.table-select tr:hover{
                background: rgb(221, 221, 221);
            }

            #selectModal .modal-dialog{
                max-width: 50%;
                height: calc(100% - 1.75rem);
            }

            #provider-datatable thead, .table thead{
                position: sticky;
                top: 0;
                background: #8ce2ff !important;
            }

            .btn-search-x{
                background-color: #0068B3;
            }
            /* .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
                background-color: #0068B3;
            } */
            .select2-container--default .select2-selection--single {
                padding: 2px;
                height: auto;
                /* font-size: 1rem; */
                font-size: 13px;
                font-weight: 400;
            }
            /* .nav-tabs{
                border-bottom: none;
            } */
            #contracts-container, #beneficiary-contracts-container {
                background-color: white;
                padding-top: 10px;
            }
            .container{
                /* margin-left: 0 !important; */
                width: 100%;
            }
        </style>
        
    </head>
    <body>
        {{-- @__include('layouts.webparts.titlebar',['no_faqs'=>true,'public'=>true,'crp'=>true]) --}}
        <div class="p-5- body-load" style="display: none;">
            <div class="container">
                <ul class="nav nav-tabs nav-pills nav-fill d-none">
                    {{-- <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#my_pending_actions">My Pending Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#legal_summary">Legal Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pending_investigations">Pending Investigations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pending_suspensions">Pending Suspensions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pending_accreditations">Pending Accreditations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pending_deviations">Pending Deviations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#calendar_menu">Calendar</a>
                    </li> --}}

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Menu</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-toggle="tab" href="#my_pending_actions" >My Pending Actions</a>
                            <a class="dropdown-item" data-toggle="tab" href="#legal_summary">Legal Summary</a>
                            <a class="dropdown-item" data-toggle="tab" href="#pending_investigations">Pending Investigations</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" data-toggle="tab" href="#pending_suspensions">Pending Suspensions</a>
                            <a class="dropdown-item" data-toggle="tab" href="#pending_accreditations">Pending Accreditations</a>
                            <a class="dropdown-item" data-toggle="tab" href="#pending_deviations">Pending Deviations</a>
                            <a class="dropdown-item" data-toggle="tab" href="#calendar_menu">Calendar</a>
                        </div>
                    </li>
                </ul>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon3">View: </span>
                    </div>
                    <select name="" id="" class="menu-selector form-control custom-select custom-select-lg">
                        <option value="#my_pending_actions">My Pending Actions</option>
                        <option value="#legal_summary">Legal Summary</option>
                        <option value="#pending_investigations">Pending Investigations</option>
                        <option value="#pending_suspensions">Pending Suspensions</option>
                        <option value="#pending_accreditations">Pending Accreditations</option>
                        <option value="#pending_deviations">Pending Deviations</option>
                        <option value="#open_audit_activities">Open Audit Activities</option>
                        <option value="#calendar_menu">Calendar</option>
                    </select>
                </div>
            </div>
            
            <div class="container">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active mt-4" id="my_pending_actions">
                        <table id="pending-actions-table" class="table table-striped table-bordered table-hover" style="width:100%">
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
                    <div class="tab-pane fade mt-4" id="legal_summary">
                        <div>
                            <div class="form-group row">
                                <label for="financial-year-text" class="col-sm-2 col-form-label text-right">Financial Year:</label>
                                <div class="col-sm-8 input-group">
                                    <select name="financial_year" class="form-control" id="financial-year-select"></select>
                                    <span class="input-group-btn">
                                        <a href="javascript://" class="btn btn-primary btn-sm btn-generate-fy-summary">Generate Report</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="fy-legal-summary"></div>
                    </div>
                    <div class="tab-pane fade mt-4" id="pending_investigations">
                        {{-- <div class="alert alert-danger">This is still work in progress!</div> --}}
                        <table id="pending-investigations-table" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Financial Year</th>
                                    <th>Entity</th>
                                    <th>Subject of Investigation</th>
                                    <th>Procurement Files</th>
                                    <th>Date of Receipt</th>
                                    <th>Process Duration</th>
                                    <th>Last Status Update</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade mt-4" id="pending_suspensions">
                        <table id="pending-suspensions-table" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Financial Year</th>
                                    <th>Provider</th>
                                    <th>Date of Receipt</th>
                                    <th>Process Duration</th>
                                    <th>Last Status Update</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade mt-4" id="pending_accreditations">
                        <table id="pending-accreditations-table" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Financial Year</th>
                                    <th>Entity</th>
                                    <th>Date of Receipt</th>
                                    <th>Subject</th>
                                    <th>Last Status Update</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade mt-4" id="pending_deviations">
                        <table id="pending-deviations-table" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Financial Year</th>
                                    <th>Entity</th>
                                    <th>Date of Receipt</th>
                                    <th>Subject</th>
                                    <th>Last Status Update</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade mt-4" id="open_audit_activities">
                        <div id="open-audit-activities-table"></div>
                    </div>
                    <div class="tab-pane fade mt-4" id="calendar_menu">
                        <div class="alert alert-danger">This is still work in progress!</div>
                        <div id="calendar_container"></div>
                    </div>
                </div>
            </div>
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

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script>
            //var server = "https://192.168.33.18:1000/api/";
            // var server = "http://127.0.0.1:8003/api/";
            //var server = "http://ppda.emis/api/";
            //var server = "https://154.72.195.226:1000/api/";
            //var server = 'https://api-server.ppda.go.ug:1000/api/';
            var server = "{{endpoint('api_router')}}";
            var device = null
            var user = null
            var dataSet = {}
            var pending_actions_data = []
            var pending_investigations_data = []
            var dt_pending_actions
            var dt_pending_investigations

            $(document).ready(function() {
                //check whether this device is trusted is ready
                var url = "{{ route('trusted-devices.ajax') }}";
                var server_error_msg = '<div class="alert alert-danger">ERROR: There is no Trusted Device found!!</div>';
                var financial_years, entities
                //$.get(url,function(data){
                    //console.log(data)
                    //if(/Valid Cookie Approved/.test(data)){
                        $('.server-data-overlay').hide()
                        $('.body-load').show()

                        // var jsonData = JSON.parse(data)
                        // device = jsonData.trustedDevice
                        // user = device.username
                        user = "{{$user}}"

                        load_legal_summary();
                        load_open_audit_activities();

                        load_my_pending_actions();
                        load_pending_investigations();
                        load_pending_suspensions();
                        load_pending_accreditations();
                        load_pending_deviations();

                    // }else{
                    //     $('.server-data-overlay .overlay-message').html(server_error_msg)
                    // }
                //}).fail(function() {
                    //$('.server-data-overlay .overlay-message').html(server_error_msg)
                //})



                $('.body-load .nav-tabs a').on('hide.bs.tab', function(event){
                    
                });

                $('.body-load .nav-tabs a').on('show.bs.tab', function(event){
                    var this_target = event.target
                });

                $('.menu-selector').on('change',function(){
                    var href = $('option:selected',$(this)).val()
                    $('.tab-pane').removeClass('active').addClass('fade')
                    $(href).addClass('active').removeClass('fade')
                })


                function load_my_pending_actions(){
                    pending_actions_data = [];
                    dt_pending_actions = $('#pending-actions-table').DataTable({
                            'searching':true,
                            'responsive': true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':pending_actions_data,
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
                }

                function fetch_emis_pending_actions(){
                    var requisition_action_url = "{{ endpoint('EMIS_GET_PENDING_ACTIONS') }}"+user
                    $.getJSON( requisition_action_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_actions_data = data.data;
                            dt_pending_actions.rows.add(pending_actions_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function fetch_appraisal_pending_actions(){
                    var appraisal_action_url = "{{ endpoint('APPRAISAL_GET_PENDING_ACTIONS') }}"+user
                    $.getJSON( appraisal_action_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_actions_data = data.data;
                            dt_pending_actions.rows.add(pending_actions_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function fetch_actionlog_pending_actions(){
                    var action_log_url = "{{ endpoint('ACTIONLOG_GET_PENDING_ACTIONS') }}"+user
                    $.getJSON( action_log_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_actions_data = data.data;
                            dt_pending_actions.rows.add(pending_actions_data).draw();
                        }else{
                            bootbox.alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function fetch_stores_pending_actions(){
                    var stores_action_url = "{{ endpoint('STORES_GET_PENDING_ACTIONS') }}"+user
                    $.getJSON( stores_action_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_actions_data = data.data;
                            dt_pending_actions.rows.add(pending_actions_data).draw();
                        }else{
                            bootbox.alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function load_pending_investigations(){
                    pending_investigations_data = [];
                    dt_pending_investigations = $('#pending-investigations-table').DataTable({
                            'searching':true,
                            'responsive': true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':pending_actions_data,
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'Pending Investigations'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'Pending Investigations'
                                }
                            ],
                            "language": {
                                "emptyTable": "No Pending Investigations found!!"
                            }
                        });
                    fetch_emis_pending_investigations();
                }

                function fetch_emis_pending_investigations(){
                    var pending_investigation_url = "{{ endpoint('EMIS_GET_PENDING_INVESTIGATIONS') }}"
                    $.getJSON( pending_investigation_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_investigations_data = data.data;
                            dt_pending_investigations.rows.add(pending_investigations_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function load_pending_suspensions(){
                    pending_suspensions_data = [];
                    dt_pending_suspensions = $('#pending-suspensions-table').DataTable({
                            'searching':true,
                            'responsive': true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':pending_actions_data,
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'Pending Suspensions'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'Pending Suspensions'
                                }
                            ],
                            "language": {
                                "emptyTable": "No Pending Suspensions found!!"
                            }
                        });
                    fetch_emis_pending_suspensions();
                }

                function fetch_emis_pending_suspensions(){
                    var pending_suspensions_url = "{{ endpoint('EMIS_GET_PENDING_SUSPENSIONS') }}"
                    $.getJSON( pending_suspensions_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_suspensions_data = data.data;
                            dt_pending_suspensions.rows.add(pending_suspensions_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }



                ///accreditations
                function load_pending_accreditations(){
                    pending_accreditations_data = [];
                    dt_pending_accreditations = $('#pending-accreditations-table').DataTable({
                            'searching':true,
                            'responsive': true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':pending_accreditations_data,
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'Pending Accreditations'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'Pending Accreditations'
                                }
                            ],
                            "language": {
                                "emptyTable": "No Pending Accreditations found!!"
                            }
                        });
                    fetch_emis_pending_accreditations();
                }
                function fetch_emis_pending_accreditations(){
                    var pending_accreditation_url = "{{ endpoint('EMIS_GET_PENDING_ACCREDITATIONS') }}"
                    $.getJSON( pending_accreditation_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_accreditations_data = data.data;
                            dt_pending_accreditations.rows.add(pending_accreditations_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                ///deviations
                function load_pending_deviations(){
                    pending_deviations_data = [];
                    dt_pending_deviations = $('#pending-deviations-table').DataTable({
                            'searching':true,
                            'responsive': true,
                            'lengthMenu': [[100, -1], [100, "All"]],
                            'data':pending_deviations_data,
                            'buttons': [
                                {
                                    extend: 'pdf',
                                    text: 'Export to PDF',
                                    title: 'Pending Deviations'
                                },
                                {
                                    extend: 'csv',
                                    text: 'Export to Excel',
                                    title: 'Pending Deviations'
                                }
                            ],
                            "language": {
                                "emptyTable": "No Pending Deviations found!!"
                            }
                        });
                    fetch_emis_pending_deviations();
                }

                function fetch_emis_pending_deviations(){
                    var pending_deviations_url = "{{ endpoint('EMIS_GET_PENDING_DEVIATIONS') }}"
                    $.getJSON( pending_deviations_url, function( data ) {
                        if(data.statusCode == 0){
                            pending_deviations_data = data.data;
                            dt_pending_deviations.rows.add(pending_deviations_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function load_legal_summary(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_LEGAL_SUMMARY') }}/default"
                    var financial_years
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        financial_years = JSON.parse(data.data)
                        selected = data.selected
                        let dropdown = $('#financial-year-select');
                        dropdown.empty();
                        //dropdown.append('<option selected="true" disabled>Choose Financial Year</option>');
                        dropdown.prop('selectedIndex', selected);
                        $.each(financial_years, function (fy, fy_id) {
                            if(fy_id == selected){
                                dropdown.append($('<option></option>').attr('value', fy_id).text(fy).prop('selected',true));
                            }else{
                                dropdown.append($('<option></option>').attr('value', fy_id).text(fy));
                            }
                        })
                        $('#fy-legal-summary').html(data.view)
                    });
                }

                function load_open_audit_activities(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_OPEN_AUDIT_ACTIVITIES') }}"
                    $.get( url, function( data ) {
                        $('#open-audit-activities-table').html(data)
                    });
                }

                $('body').on('click','.btn-generate-fy-summary',function(e){
                    e.preventDefault()
                    $('#fy-legal-summary').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#financial-year-select')).val()
                    var url = "{{ endpoint('EMIS_GET_LEGAL_SUMMARY') }}/"+selected
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        $('#fy-legal-summary').html(data.view)
                    });
                })


            } );


            
        </script>
    </body>
</html>
