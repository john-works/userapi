<!DOCTYPE html>
<html>
    <head>
        <title>Management Dashboards</title>
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" /> --}}

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
            #megaModal .modal-dialog{
                width: 92%;
                height: 100%;
            }
            #megaModal .modal-dialog .modal-content{
                height: 100%;
                overflow: auto;
            }

            #provider-datatable thead, .table thead{
                position: sticky;
                top: 0;
                background: #8ce2ff !important;
            }

            .hide_last_column tr th:last-child, .hide_last_column tr td:last-child{
                display: none;
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
                margin-left: 0 !important;
                width: 100%;
            }
            #randomActionModal .modal-dialog {
                left: 3%;
                width: 94%;
            }
        </style>
        
    </head>
    <body>
        {{-- @__include('layouts.webparts.titlebar',['no_faqs'=>true,'public'=>true,'crp'=>true]) --}}
        <div class="p-5- body-load" style="display: none;">
            <div class="container">
                <ul class="nav nav-tabs nav-pills nav-fill">
                    {{-- @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#my_pending_actions">My Pending Actions</a>
                        </li>
                    @endif --}}

                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#audit_tracker_actions">Audit Tracker Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#audit_status_report">Audit Status Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#audit_tracker_summary_2">Audit Tracker Summary</a>
                    </li>

                    @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#legal_summary">Legal Summary [WIP]</a>
                        </li>
                    @endif
                    @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pending_investigations">Pending Investigations [WIP]</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pending_suspensions">Suspension Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#suspensions_periodic">Suspension Periodic Report</a>
                    </li>
                    @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pending_accreditations">Pending Accreditations [WIP]</a>
                        </li>
                    @endif
                    @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pending_deviations">Pending Deviations [WIP]</a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#audit_tracker_summary">Audit Tracker Details</a>
                    </li> --}}
              
                    @if($is_admin == 'true')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#calendar_menu">Calendar [WIP]</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#fleet_menu">Fleet</a>
                    </li>
                </ul>
            </div>
                
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane mt-4" id="my_pending_actions">
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
                <div class="tab-pane mt-4" id="pending_suspensions">
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
                <div class="tab-pane mt-4" id="suspensions_periodic">
                    <div>
                        <div class="form-group row">
                            <label for="financial-year-text" class="col-sm-2 col-form-label text-right">Financial Year:</label>
                            <div class="col-sm-8 input-group">
                                <select name="financial_year_suspension" class="form-control" id="suspension-financial-year-select"></select>
                                <span class="input-group-btn">
                                    <a href="javascript://" class="btn btn-primary btn-sm btn-generate-suspension-fy-periodic">Generate Report</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="fy-suspension-periodic-report"></div>
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
                <div class="tab-pane fade mt-4" id="audit_tracker_summary">
                    <div>
                        <div class="form-group row">
                            <label for="financial-year-text" class="col-sm-2 col-form-label text-right">Financial Year:</label>
                            <div class="col-sm-8 input-group">
                                <select name="financial_year" class="form-control" id="audit-financial-year-select"></select>
                                <span class="input-group-btn">
                                    <a href="javascript://" class="btn btn-primary btn-sm btn-generate-audit-fy-summary">Generate Report</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="fy-audit-tracker-summary"></div>
                </div>
                <div class="tab-pane fade mt-4" id="audit_tracker_summary_2">
                    <div>
                        <div class="form-group row">
                            <label for="financial-year-text" class="col-sm-2 col-form-label text-right">Financial Year:</label>
                            <div class="col-sm-8 input-group">
                                <select name="financial_year_2" class="form-control" id="audit-financial-year-select-2"></select>
                                <span class="input-group-btn">
                                    <a href="javascript://" class="btn btn-primary btn-sm btn-generate-audit-fy-summary-2">Generate Report</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="fy-audit-tracker-summary-2"></div>
                </div>
                <div class="tab-pane active in fade mt-4" id="audit_tracker_actions">
                    <div>
                        <div class="form-group row">
                            <label for="office-text" class="col-sm-2 col-form-label text-right">Office:</label>
                            <div class="col-sm-8 input-group">
                                <select name="office_2" class="form-control" id="audit-office-select"></select>
                                <span class="input-group-btn">
                                    <a href="javascript://" class="btn btn-primary btn-sm btn-generate-audit-tracker-actions">Generate Report</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="my-audit-tracker-actions"></div>
                </div>
                <div class="tab-pane fade mt-4" id="audit_status_report">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="office-text" class="col-sm-2- col-form-label text-right">Financial Year:</label>
                            <div class="">
                                <select name="financial_year_status_report" class="form-control" id="audit-status-financial-year-select"></select>
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label for="office-text" class="col-sm-2- col-form-label text-right">Office:</label>
                            <div class="col-sm-12 input-group">
                                <select name="office_3" class="form-control" id="audit-status-office-select"></select>
                                <span class="input-group-btn">
                                    <a href="javascript://" class="btn btn-primary btn-sm btn-generate-audit-status-report">Generate Report</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="my-audit-status-report"></div>
                </div>
                <div class="tab-pane fade mt-4" id="calendar_menu">
                    <div class="alert alert-danger">This is still work in progress!</div>
                    <div id="calendar_container"></div>
                </div>
                <div class="tab-pane fade mt-4" id="fleet_menu">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">License Expiry Report</div>
                                <div class="panel-body">
                                    <table id="license-expiry-table" class="table table-striped table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>License Number</th>
                                                <th>License Issue date</th>
                                                <th>License Expry Date</th>
                                                <th>No of days to Expiry</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Insurance Expiry Report</div>
                                <div class="panel-body">
                                    <table id="insurance-expiry-table" class="table table-striped table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Vehicle Number Plate</th>
                                                <th>Vehicle Type</th>
                                                <th>Insurance Type</th>
                                                <th>Insurance Company</th>
                                                <th>Insurance Start Date</th>
                                                <th>Insurance End Date</th>
                                                <th>No of Days to Expiry</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Lapsed Mileage Report</div>
                                <div class="panel-body">
                                    <table id="lapsed-mileage-table" class="table table-striped table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Vehicle Type</th>
                                                <th>Vehicle Number Plate</th>
                                                <th>Last Mileage Reading</th>
                                                <th>Last Mileage Date</th>
                                                <th>Last Update</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Service Expiry Report</div>
                                <div class="panel-body">
                                    <table id="service-expiry-table" class="table table-striped table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Vehicle Number Plate</th>
                                                <th>Vehicle Type</th>
                                                <th>Next Service Mileage</th>
                                                <th>Last Mileage Reading</th>
                                                <th>Last Mileage Date</th>
                                                <th>Miles Left to Service</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                              </div>
                        </div>
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

        {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}

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
            var license_expiry_data = []
            var insurance_expiry_data = []
            var service_expiry_data = []
            var lapsed_mileage_data = []
            var dt_pending_actions
            var dt_pending_investigations
            var dt_license_expiry
            var dt_insurance_expiry
            var dt_service_expiry
            var dt_lapsed_mileage

            $(document).ready(function() {
                //check whether this device is trusted is ready
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

                        load_legal_summary();
                        load_audit_status_report()
                        load_audit_tracker_summary();
                        load_audit_tracker_summary_2();
                        load_audit_tracker_actions();
                        load_my_pending_actions();
                        load_pending_investigations();
                        load_pending_suspensions();
                        load_pending_accreditations();
                        load_pending_deviations();
                        load_license_expiry_report();
                        load_insurance_expiry_report();
                        load_service_expiry_report();
                        load_lapsed_mileage_report();

                        load_suspension_periodic_report();

                    }else{
                        $('.server-data-overlay .overlay-message').html(server_error_msg)
                    }
                }).fail(function() {
                    $('.server-data-overlay .overlay-message').html(server_error_msg)
                })



                $('.body-load .nav-tabs a').on('hide.bs.tab', function(event){
                    
                });

                $('.body-load .nav-tabs a').on('show.bs.tab', function(event){
                    var this_target = event.target
                });


                function load_my_pending_actions(){
                    pending_actions_data = [];
                    dt_pending_actions = $('#pending-actions-table').DataTable({
                            'searching':true,
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
                    /* pending_suspensions_data = [];
                    dt_pending_suspensions = $('#pending-suspensions-table').DataTable({
                            'searching':true,
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
                        }); */
                    fetch_emis_pending_suspensions();
                }

                function fetch_emis_pending_suspensions(){
                    // var pending_suspensions_url = "{{ endpoint('EMIS_GET_PENDING_SUSPENSIONS') }}"
                    // $.getJSON( pending_suspensions_url, function( data ) {
                    //     if(data.statusCode == 0){
                    //         pending_suspensions_data = data.data;
                    //         dt_pending_suspensions.rows.add(pending_suspensions_data).draw();
                    //     }else{
                    //         alert(data.statusDescription);
                    //     }
                    //     $('.my-data-overlay').hide();
                    // }).fail(function(){
                    //     alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    // });
                    var suspension_container = $('#pending_suspensions')
                    var url = "{{ endpoint('EMIS_GET_PENDING_SUSPENSIONS_2') }}"
                    $.getJSON( url, function( data ) {
                        if(data.statusCode == 0){
                            suspension_container.html(data.view)
                        }else{
                            suspension_container.html(data.statusDescription)
                        }
                    });
                }



                ///accreditations
                function load_pending_accreditations(){
                    pending_accreditations_data = [];
                    dt_pending_accreditations = $('#pending-accreditations-table').DataTable({
                            'searching':true,
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
                $('body').on('click','.btn-generate-fy-summary',function(e){
                    e.preventDefault()
                    $('#fy-legal-summary').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#financial-year-select')).val()
                    var url = "{{ endpoint('EMIS_GET_LEGAL_SUMMARY') }}/"+selected
                    $.getJSON( url, function( data ) {
                        // console.log(data)
                        $('#fy-legal-summary').html(data.view)
                    });
                })

                function load_audit_tracker_summary(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_SUMMARY') }}/default"
                    var financial_years
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        financial_years = JSON.parse(data.data)
                        selected = data.selected
                        let dropdown = $('#audit-financial-year-select');
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
                        $('#fy-audit-tracker-summary').html(data.view)
                    });
                }

                function load_audit_status_report(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_AUDIT_STATUS_REPORT') }}/default"
                    var financial_years
                    var offices
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        financial_years = JSON.parse(data.data)
                        offices = JSON.parse(data.offices)

                        //financial years
                        selected = data.selected
                        let dropdown = $('#audit-status-financial-year-select');
                        dropdown.empty();
                        dropdown.prop('selectedIndex', selected);
                        $.each(financial_years, function (fy, fy_id) {
                            if(fy_id == selected){
                                dropdown.append($('<option></option>').attr('value', fy_id).text(fy).prop('selected',true));
                            }else{
                                dropdown.append($('<option></option>').attr('value', fy_id).text(fy));
                            }
                        })

                        //offices
                        dropdown = $('#audit-status-office-select');
                        dropdown.empty();
                        //dropdown.append('<option selected="true" disabled>Choose Financial Year</option>');
                        dropdown.prop('selectedIndex', selected);
                        $.each(offices, function (code, name) {
                            if(code == selected){
                                dropdown.append($('<option></option>').attr('value', code).text(name).prop('selected',true));
                            }else{
                                dropdown.append($('<option></option>').attr('value', code).text(name));
                            }
                        })

                        //view
                        $('#my-audit-status-report').html(data.view)
                    });
                }

                function load_audit_tracker_summary_2(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_SUMMARY_2') }}/default"
                    var financial_years
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        financial_years = JSON.parse(data.data)
                        selected = data.selected
                        let dropdown = $('#audit-financial-year-select-2');
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
                        $('#fy-audit-tracker-summary-2').html(data.view)
                    });
                }

                function load_suspension_periodic_report(){
                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_SUSPENSION_PERIODIC_REPORT') }}/default"
                    var financial_years
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        financial_years = JSON.parse(data.data)
                        selected = data.selected
                        let dropdown = $('#suspension-financial-year-select');
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
                        $('#fy-suspension-periodic-report').html(data.view)
                    });
                }

                function load_audit_tracker_actions(){

                    //get financial years
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_ACTIONS') }}/default"
                    var offices
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        offices = JSON.parse(data.data)
                        selected = data.selected
                        let dropdown = $('#audit-office-select');
                        dropdown.empty();
                        //dropdown.append('<option selected="true" disabled>Choose Financial Year</option>');
                        dropdown.prop('selectedIndex', selected);
                        $.each(offices, function (code, name) {
                            if(code == selected){
                                dropdown.append($('<option></option>').attr('value', code).text(name).prop('selected',true));
                            }else{
                                dropdown.append($('<option></option>').attr('value', code).text(name));
                            }
                        })
                        $('#my-audit-tracker-actions').html(data.view)
                    });


                    //get financial years
                    // $('#audit_tracker_actions>div').html('loading data... Please wait')
                    // var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_ACTIONS') }}"
                    // $.get( url, function( data ) {
                    //     $('#audit_tracker_actions>div').html(data)
                    // });
                }
                
                function load_license_expiry_report(){
                    license_expiry_data = [];
                    dt_license_expiry = $('#license-expiry-table').DataTable({
                        'info': false,
                        'paging': false,
                        'searching': false,
                        'lengthMenu': [[100, -1], [100, "All"]],
                        'data':license_expiry_data,
                        'order': [],
                        'buttons': [
                            {
                                extend: 'pdf',
                                text: 'Export to PDF',
                                title: 'License Expiry Report'
                            },
                            {
                                extend: 'csv',
                                text: 'Export to Excel',
                                title: 'License Expiry Report'
                            }
                        ],
                        "language": {
                            "emptyTable": "No License Expiry Data found!!"
                        }
                    });
                    fetch_fleet_license_expiry();
                }

                function fetch_fleet_license_expiry(){
                    var license_expiry_url = "{{ endpoint('FLEET_GET_LICENSE_EXPIRY') }}"
                    $.getJSON( license_expiry_url, function( data ) {
                       
                        if(data.statusCode == 0){
                            license_expiry_data = data.data;
                            dt_license_expiry.rows.add(license_expiry_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function load_insurance_expiry_report(){
                    insurance_expiry_data = [];
                    dt_insurance_expiry = $('#insurance-expiry-table').DataTable({
                        'info': false,
                        'paging': false,
                        'searching': false,
                        'lengthMenu': [[100, -1], [100, "All"]],
                        'data':insurance_expiry_data,
                        'order': [],
                        'buttons': [
                            {
                                extend: 'pdf',
                                text: 'Export to PDF',
                                title: 'Insurance Expiry Report'
                            },
                            {
                                extend: 'csv',
                                text: 'Export to Excel',
                                title: 'Insurance Expiry Report'
                            }
                        ],
                        "language": {
                            "emptyTable": "No Insurance Expiry Details Found!!"
                        }
                    });
                    fetch_fleet_insurance_expiry();
                }

                function fetch_fleet_insurance_expiry(){
                    var insurance_expiry_url = "{{ endpoint('FLEET_GET_INSURANCE_EXPIRY') }}"
                    $.getJSON( insurance_expiry_url, function( data ) {
                        if(data.statusCode == 0){
                            insurance_expiry_data = data.data;
                            dt_insurance_expiry.rows.add(insurance_expiry_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }
                function load_service_expiry_report(){
                    service_expiry_data = [];
                    dt_service_expiry = $('#service-expiry-table').DataTable({
                        'info': false,
                        'paging': false,
                        'searching': false,
                        'lengthMenu': [[100, -1], [100, "All"]],
                        'data':service_expiry_data,
                        'order': [],
                        'buttons': [
                            {
                                extend: 'pdf',
                                text: 'Export to PDF',
                                title: 'Service Expiry Report'
                            },
                            {
                                extend: 'csv',
                                text: 'Export to Excel',
                                title: 'Service Expiry Report'
                            }
                        ],
                        "language": {
                            "emptyTable": "No Service Expiry Details Found!!"
                        }
                    });
                    fetch_fleet_service_expiry();
                }

                function fetch_fleet_service_expiry(){
                    var service_expiry_url = "{{ endpoint('FLEET_GET_SERVICE_EXPIRY') }}"

                    $.getJSON( service_expiry_url, function( data ) {
                        if(data.statusCode == 0){
                            service_expiry_data = data.data;
                            console.log(service_expiry_data)
                            dt_service_expiry.rows.add(service_expiry_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                function load_lapsed_mileage_report(){
                    lapsed_mileage_data = [];
                    dt_lapsed_mileage = $('#lapsed-mileage-table').DataTable({
                        'info': false,
                        'paging': false,
                        'searching': false,
                        'lengthMenu': [[100, -1], [100, "All"]],
                        'data':lapsed_mileage_data,
                        'order':[],
                        'buttons': [
                            {
                                extend: 'pdf',
                                text: 'Export to PDF',
                                title: 'Lapsed Mileage Report'
                            },
                            {
                                extend: 'csv',
                                text: 'Export to Excel',
                                title: 'Lapsed Mileage Report'
                            }
                        ],
                        "language": {
                            "emptyTable": "No Lapsed Mileage Report found!!"
                        }
                    });
                    fetch_fleet_lapsed_mileage();
                }

                function fetch_fleet_lapsed_mileage(){
                    var lapsed_mileage_url = "{{ endpoint('FLEET_GET_LAPSED_MILEAGE') }}"
                    $.getJSON( lapsed_mileage_url, function( data ) {
                        if(data.statusCode == 0){
                            lapsed_mileage_data = data.data;
                            dt_lapsed_mileage.rows.add(lapsed_mileage_data).draw();
                        }else{
                            alert(data.statusDescription);
                        }
                        $('.my-data-overlay').hide();
                    }).fail(function(){
                        alert('Sorry, we encountered an error while loading the data. Please try again later.');
                    });
                }

                $('body').on('click','.btn-generate-audit-fy-summary',function(e){
                    e.preventDefault()
                    $('#fy-audit-tracker-summary').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#audit-financial-year-select')).val()
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_SUMMARY') }}/"+selected
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        $('#fy-audit-tracker-summary').html(data.view)
                    });
                })

                $('body').on('click','.btn-generate-audit-fy-summary-2',function(e){
                    e.preventDefault()
                    $('#fy-audit-tracker-summary-2').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#audit-financial-year-select-2')).val()
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_SUMMARY_2') }}/"+selected
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        $('#fy-audit-tracker-summary-2').html(data.view)
                    });
                })

                $('body').on('click','.btn-generate-suspension-fy-periodic',function(e){
                    e.preventDefault()
                    $('#fy-suspension-periodic-report').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#suspension-financial-year-select')).val()
                    var url = "{{ endpoint('EMIS_GET_SUSPENSION_PERIODIC_REPORT') }}/"+selected
                    $.getJSON( url, function( data ) {
                        //console.log(data)
                        $('#fy-suspension-periodic-report').html(data.view)
                    });
                })

                $('body').on('click','.btn-generate-audit-tracker-actions',function(e){
                    e.preventDefault()
                    $('#my-audit-tracker-actions').html('... loading ... <br><br><br> Please Wait!!')
                    var selected = $('option:selected',$('#audit-office-select')).val()
                    var url = "{{ endpoint('EMIS_GET_AUDIT_TRACKER_ACTIONS') }}/"+selected
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        $('#my-audit-tracker-actions').html(data.view)
                    });
                })

                $('body').on('click','.btn-generate-audit-status-report',function(e){
                    e.preventDefault()
                    $('#my-audit-status-report').html('... loading ... <br><br><br> Please Wait!!')
                    var fy = $('option:selected',$('#audit-status-financial-year-select')).val()
                    var off = $('option:selected',$('#audit-status-office-select')).val()
                    var url = "{{ endpoint('EMIS_GET_AUDIT_STATUS_REPORT') }}/"+fy+"/"+off
                    $.getJSON( url, function( data ) {
                        console.log(data)
                        $('#my-audit-status-report').html(data.view)
                    });
                })


            } );


            
        </script>
    </body>
</html>
