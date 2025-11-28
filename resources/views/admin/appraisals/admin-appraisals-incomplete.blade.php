
@extends('layouts.master-admin')
@section('title')
    Admin | Incomplete Appraisals
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
        <h5>INCOMPLETE APPRAISALS</h5>

        <div class="col s12 btn-group-minier" style="margin-top: 10px;margin-bottom: 10px">
            <label>Filter by Status:</label>
            <select class="browser-default" style="width: 200px !important;" id="ddAppraisalStatus">
                <option value="">All</option>
                <option value="{{PENDING_SUPERVISOR_APPROVAL}}" {{$statusFilter == PENDING_SUPERVISOR_APPROVAL ? 'selected' : '' }} >Pending Just Supervisor</option>
                <option value="{{PENDING_DEPARTMENT_HEAD_APPROVAL}}" {{$statusFilter == PENDING_DEPARTMENT_HEAD_APPROVAL ? 'selected' : '' }}>Pending Just HOD</option>
                <option value="{{PENDING_EXECUTIVE_DIRECTOR_APPROVAL}}"  {{$statusFilter == PENDING_EXECUTIVE_DIRECTOR_APPROVAL ? 'selected' : '' }}>Pending Just ED</option>
            </select>
            <a href="{{route('admin.appraisals.incomplete',['PARAM_STATUS_CODE'])}}" class="btn btn-small" style="text-transform: capitalize;background: #0D47A1;margin-left: 2em" id="btnSearchIncompleteAppraisalsByStatus">Filter</a>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="page-length-option">

            <thead class="timo-admin-table-head">
            <tr>
                <th >Appraisal Type</th>
                <th >Appraisal Name</th>
                <th>Change Approver</th>
                <th>Supervisor</th>
                <th>Supervisor Decision</th>
                <th>Employee Acceptance</th>
                <th>HOD</th>
                <th>HOD Decision</th>
                <th>ED</th>
                <th>ED Decision</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($appraisals) || count($appraisals) == 0)
                <tr><td class="center" colspan="6">No incomplete appraisals found in the system</td></tr>
            @else
                @foreach($appraisals as $appraisal)
                    <tr>
                        <td>{{isset($appraisal->appraisalType) ? ucwords(strtolower($appraisal->appraisalType)) : ""}}</td>
                        <td>{{$appraisal->generatedPdfName}}</td>
                        <td><a data-supervisor="{{$appraisal->supervisorUsername}}" data-hod="{{$appraisal->deptHeadUsername}}" data-ed="{{$appraisal->executiveDirectorUsername}}" data-appraisal-ref="{{$appraisal->appraisalRef}}" class="green-text modal-trigger edit-btn-appraisal-approvers" href="#modal_appraisal_approvers"><i class="material-icons center">edit</i></a></td>
                        <td>{{$appraisal->supervisorUsername}}</td>
                        <td>{{$appraisal->supervisorDecision}}</td>
                        <td>{{$appraisal->employeeAcceptanceStatus}}</td>
                        <td>{{$appraisal->deptHeadUsername}}</td>
                        <td>{{$appraisal->deptHeadDecision}}</td>
                        <td>{{$appraisal->executiveDirectorUsername}}</td>
                        <td>{{$appraisal->executiveDirectorDecision}}</td>
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

    @include('admin.appraisals.modal-appraisal-approvers')

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
