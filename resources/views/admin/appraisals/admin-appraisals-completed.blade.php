
@extends('layouts.master-admin')
@section('title')
    Admin | Completed Appraisals
@endsection

@section('page-level-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/css/data-tables.css')}}">
@endsection

@section('content')

    <div class="container">

        <div class="col s12 spacer"></div>
        <h5>COMPLETED APPRAISALS</h5>

        <table class="bordered table table-hover table-tiny-text" id="page-length-option">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Appraisal Type</th>
                <th>Appraisal Name</th>
                <th>Supervisor</th>
                <th>Supervisor Approval Date</th>
                <th>Employee Acceptance</th>
                <th>HOD</th>
                <th>HOD Approval Date</th>
                <th>ED</th>
                <th>ED Approval Date</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($appraisals) || count($appraisals) == 0)
                <tr><td class="center" colspan="7">No completed appraisals found in the system</td></tr>
            @else
                @foreach($appraisals as $appraisal)
                    <tr>
                        <td>{{isset($appraisal->appraisalType) ? ucwords(strtolower($appraisal->appraisalType)) : ""}}</td>
                        <td>{{$appraisal->generatedPdfName}}</td>
                        <td>{{$appraisal->supervisorUsername}}</td>
                        <td>{{$appraisal->supervisorActionDate}}</td>
                        <td>{{$appraisal->employeeAcceptanceStatus}}</td>
                        <td>{{$appraisal->deptHeadUsername}}</td>
                        <td>{{$appraisal->deptHeadActionDate}}</td>
                        <td>{{$appraisal->executiveDirectorUsername}}</td>
                        <td>{{$appraisal->executiveDirectorActionDate}}</td>
                       </tr>

                @endforeach
            @endif

            </tbody>

        </table>

        <div class="col s12 spacer"></div>
        <div class="col s12 center">
            <div><span id="total_users"></span></div>
            <ul class="pagination pager" id="myPager"></ul>
        </div>

    </div>


    {{-- Helper Modals are below --}}

    @if(isset($deletionMessage))

        <div id="modal_deletion" class="modal">
            <div class="modal-content">
                <h5>User Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

    {{-- End Helper Modals --}}

@endsection

@section('page-level-js')

    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/js/scripts/data-tables.js')}}" type="text/javascript"></script>

@endsection
