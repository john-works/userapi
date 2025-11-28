<!doctype html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
   <link rel="icon" href="favicon.ico?v=2" type="image/x-icon"/>
    @yield('no-cache')
    <link rel="stylesheet" href="{{ URL::asset('css/materialize.min.css') }}" type="text/css"/>
    @yield('page-level-css')

    {{--<link rel="stylesheet" href="{{ URL::asset('css/styles-min.css') }}" type="text/css"/>--}}
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ URL::asset('css/chosen.css') }}" type="text/css"/>

    <script src="{{ URL::asset('js/jquery.min.js') }}" type="text/javascript"> </script>
    <script src="{{ URL::asset('js/moment.min.js') }}" type="text/javascript"> </script>
    <script src="{{ URL::asset('materialize/js/materialize.js') }}" type="text/javascript"> </script>
    <script src="{{ URL::asset('js/jquery.validate.min.js') }}" type="text/javascript"> </script>
    @yield('page-level-js')
    <script src="{{ URL::asset('js/scripts.js') }}" type="text/javascript"> </script>
    {{--<script src="{{ URL::asset('js/scripts-min.js') }}" type="text/javascript"> </script>--}}
    <script src="{{ URL::asset('js/pagination.js') }}" type="text/javascript" ></script>
    <script src="{{ URL::asset('js/appraisal.js') }}" type="text/javascript" ></script>

</head>
<body>

@yield('content')

<!-- BEGIN: Footer-->
<footer class="page-footer footer blue darken-4">
    <div class="footer-copyright">
        <div class="container"><span>&copy; {{date('Y')}} <a class="" href="#" target="_blank">PPDA</a> All rights reserved.</span></div>
    </div>
</footer>
<!-- END: Footer-->


<div style="display: none" id="modal-progress-dialog">
    <div class="row">
        <div class="col-sm-12 spacer"></div>
        <div class="col-md-12 modal-progress-dialog-content valign-wrapper align-center" >
            <img class="valign" src="{{asset('images/tymo_preloader.gif')}}">
            <span class="valign">Please wait....</span>
        </div>
    </div>
</div>

{{-- Modal for showing dynamic content level-1 --}}
<div id="modal-base" class="modal">
    <div class="modal-content">
        <div><h5 class="modal-title" style="margin-top: 0px;display: inline-block"></h5><span class="dismiss right" style="cursor: pointer"><i class="material-icons">close</i></span></div>
        <div class="divider"></div>
        <div class="modal-body"></div>
    </div>
</div>
{{--
<div class="modal fade" id="modal-base" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                --}}{{--                <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>--}}{{--
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>--}}
{{-- Modal for showing dynamic content level-2 --}}
<div id="modal-level-1" class="modal">

    <div class="modal-content">
        <h5 class="modal-title"></h5>
        <div class="modal-body"></div>
    </div>

</div>

{{--<div class="modal fade" id="modal-level-1" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                --}}{{--                <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>--}}{{--
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>--}}

{{-- Modal for progress dialog --}}
<div class="modal fade" id="progress-dialog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-sm-12 spacer"></div>
                <div class="col-md-12 modal-progress-dialog-content valign-wrapper align-center" >
                    <img class="valign" src="{{asset('images/tymo_preloader.gif')}}">
                    <span class="valign message">Please wait....</span>
                </div>
                <div class="col-sm-12 spacer"></div>
            </div>
        </div>
    </div>
</div>

{{-- Modal for confirmation --}}
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-confirm-title" class="modal-title">Please confirm action</h4>
            </div>
            <div class="modal-body">
                <p id="modal-confirm-message"></p>
            </div>
            <div class="modal-footer">
                <button id="btn-confirm-action" data-href="" type="button" class="btn btn-link waves-effect text-success">Confirm</button>
                <button type="button" class="btn btn-link waves-effect text-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal for message box --}}
<div class="modal fade" id="message-box-dialog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
        </div>

    </div>
</div>

{{-- el final de importante modals --}}

@include('includes.modal_customizable')

<div id="tds_notifier_modal_container"></div>
<div id="tds_notifier_progress_container"></div>

<script src="{{ URL::asset('js/tds_notifier.js') }}" type="text/javascript"> </script>
<script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('DataTables/datatables.min.js') }}" type="text/javascript"> </script>


{{-- el final de Include important scripts that must be loaded before the custom script below --}}

<script type="text/javascript">

    $(function () {
        loadListing();
    });


    /*
    * Dynamically loads datatables on a given page
    * */
    function loadListing(){

        if($('.data-table').length > 0){
            $('.data-table,.inner-table').each(function(){

                var tableSelectorClass = $(this).attr('class').split(' ')[1];
                var idParam = $(this).attr('class').split(' ')[2];
                var extraParam = $(this).attr('class').split(' ')[3];
                initializeDataTables(tableSelectorClass,tableSelectorClass,idParam,extraParam);

            })
        }

    }

    /*
    * Dynamically initiates datatables
    * */
    function initializeDataTables(tableSelectorClass, tableNameInListing, idParam, extraParam){

        @include('includes.datatable_columns')

        /*
        * Replace the ID query param in the URL with the dynamic value passed
        * */
        var url = data_columns[tableNameInListing]['url'].replace("%5BID%5D",idParam);

        /*
        * Replace the EXTRA query param in the URL with the dynamic value passed
        * */
        url = url.replace("%5BEXTRA%5D",extraParam);

        /*
        * Get the columns
        * */
        var cols = data_columns[tableNameInListing]['cols'];

        /*
        * Order column index
        * */
        var orderIndexAndDirection = data_columns[tableNameInListing]['order_idx_direction'];
        var resultArr = orderIndexAndDirection.split(':');
        var orderIndex = resultArr[0];
        var orderDirection = resultArr[1];

        // if( $.fn.DataTable.isDataTable('.'+tableSelectorClass)  ){
        //     $('.'+tableSelectorClass).DataTable().ajax.reload();
        //     return
        // }

        $('.'+tableSelectorClass).DataTable({
            "bDestroy": true,
            responsive: true,
            "bProcessing": true,
            serverSide: true,
            ajax: url,
            columns: cols,
            order: [ [orderIndex, orderDirection] ],
            "buttons": [
                { extend: 'copyHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true,
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'colvis', text: 'Columns'},
            ],
        }, function(data){
            console.log("Data :::", data);
        });

    }

</script>

</body>
</html>
 
