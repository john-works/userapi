<html>
    <head>
        <title>Special Interest Groups</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
            }
            .body-load ul{
                list-style: none !important;
                margin-left: 0 !important
            }
            .body-load input[type="text"]{
                /* font-size: 1rem !important; */
                font-size: 13px !important;
            }
            .body-load .btn{
                font-size: 13px !important;
            }
            input[type="submit"].submit{
                font-size: 13px !important;
            }
            .body-load .nav-pills .nav-link{
                border-bottom-left-radius: 0!important;
                border-bottom-right-radius: 0!important;
            }
            .dt-buttons{
                float: right !important;
            }
            .dt-buttons button{
                background: #fb9191 !important;
            }
            .body-load .dataTable thead,.body-load .dataTable thead th{
                background: #8ce2ff !important;
            }
        </style>
        
    </head>
    <body>
        <div class="p-5- body-load" style="display: none;">
            <h2 class="text-center">Special Interest Groups</h2>     
            <table id="special-groups-datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Company Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mailing Address</th>
                        <th>Physical Address</th>
                        <th>BRN</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="btn-export"></div>
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
<div id="pdf"></div>
<div id="print_element_container"></div>


        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js" integrity="sha512-pdCVFUWsxl1A4g0uV6fyJ3nrnTGeWnZN2Tl/56j45UvZ1OMdm9CIbctuIHj+yBIRTUUyv6I9+OivXj4i0LPEYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            var server = 'http://127.0.0.1:8003/api/';
            //var server = 'https://154.72.195.226:1000/api/';
            //var server = 'https://api-server.ppda.go.ug:1000/api/';
            $(document).ready(function() {

                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                let today = new Date().toLocaleDateString('en-GB',options)

                //check whether api-server is ready
                var url = server + "check-server-status";
                var server_error_msg = '<div class="alert alert-danger">ERROR: There is no connection to the server. Please confirm that you are connected to the internet and try again. If the error persists please contact PPDA - Tel: +256-414-311100 and report the issue on the <u>Suspended Providers Database</u>.</div>';
                $.get(url,function(data){
                    if(data.statusCode == 0){
                        $('.server-data-overlay').hide()
                        $('.body-load').show()
                    }else{
                        $('.server-data-overlay .overlay-message').html(server_error_msg)
                    }
                }).fail(function() {
                    $('.server-data-overlay .overlay-message').html(server_error_msg)
                })


                var dataSet = [];
                var dt_interest_groups = $('#special-groups-datatable').DataTable({
                    'searching':false,
                    'lengthMenu': [[100, -1], [100, "All"]],
                    'data':dataSet,
                    "columns": [
                                { data: 'type' },
                                { data: 'company_name' },
                                { data: 'first_name' },
                                { data: 'last_name' },
                                { data: 'mailing_address' },
                                { data: 'physical_address' },
                                { data: 'brn' },
                    ],
                    'buttons': [
                        {
                            text: 'Export to PDF',
                            title: 'Special Interest Groups (As on '+today+')',
                            className: 'btn-export-pdf---'
                        }
                    ],
                    "language": {
                        "emptyTable": "No Special Interest Groups Found!!!"
                    }
                });
                
                // dt_interest_groups.buttons().container()
                //     .appendTo( $('.row:eq(0) .col-md-6:eq(1)', dt_interest_groups.table().container() ) );

                var url = server+'get_special_interest_groups';
                $.getJSON( url, function( data ) {
                    dataSet = data.data;
                    dt_interest_groups.clear().rows.add(dataSet).draw();
                    $('.my-data-overlay').hide();
                });

                $('body').on('click','.btn-export-pdf',function(){
                    $('.my-data-overlay').show();
                    var url = server+'download_suspended_providers';
                    // $.getJSON( url, function( data ) {
                    //     $('#pdf').html(data.data)
                    //     print_report_multiple_dataset('#report_graph_data')
                    //     $('.my-data-overlay').hide();
                    // });
                    $.ajax({
                        xhrFields: {
                            responseType: 'blob',
                        },
                        type: 'GET',
                        url: url,
                        success: function(result, status, xhr) {
                            var disposition = xhr.getResponseHeader('content-disposition');
                            var type = xhr.getResponseHeader('content-type');
                            var ext = /zip/i.test(type) ? 'zip' : 'pdf'
                            console.log(type)
                            // var matches = /"([^"]*)"/.exec(disposition);
                            var matches = null;
                            if(disposition != null){
                                matches = disposition.replace(/"/g,'').split('filename=');
                            }
                            var todays_date = new Date().toLocaleDateString('en-us', { year:"numeric", month:"short", day:"numeric", hour:"2-digit", minute:"2-digit", second:"2-digit"})
                            console.log(todays_date)

                            var filename = (matches != null && matches[1] ? matches[1] : 'PPDA_Suspended_Providers_List_'+todays_date+'.'+ext);
                            filename = filename.replaceAll(' ','_');
                            filename = filename.replaceAll('-','_');
                            filename = filename.replaceAll(',','');

                            // The actual download
                            var blob = new Blob([result], {
                                type: type
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;

                            document.body.appendChild(link);

                            link.click();
                            document.body.removeChild(link);
                            $('.my-data-overlay').hide();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $('.my-data-overlay').hide();
                            $('.server-data-overlay .overlay-message').html('Ooops, something has not gone right, please try again later!')
                            $('.server-data-overlay').show()
                            setTimeout(function(){
                                $('.server-data-overlay').hide()
                            },5000)
                        }
                    });
                })
                
            } );

            function print_report_multiple_dataset(element) {
                //heights for dynamic
                var staticHeight = 0;
                var pageHeight = 670;
                var printLayout = 'portrait';

                //begin get multiple data sets to print
                var dataToExport = '';
                dataToExport = $(element).html();
                $('#print_element_container').html(dataToExport);
                var elementToPrint = document.getElementById('print_element_container');
                var opt = {
                    pagebreak:    {  mode: ['avoid-all', 'css', 'legacy'],before: '.beforeClass' },
                    margin:       [1, 0.2],//1,
                    filename:     'Suspended_Providers_Report.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'letter', orientation: printLayout }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(elementToPrint).save();

                // $('#print_element_container').html('');
                // return;
                // return
            }

        </script>
    </body>
</html>
